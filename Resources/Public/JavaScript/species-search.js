function highlightSpeciesMatches(cell, pattern, marks) {
    const walker = document.createTreeWalker(cell, NodeFilter.SHOW_TEXT);
    const textNodes = [];
    while (walker.nextNode()) {
        textNodes.push(walker.currentNode);
    }

    for (const node of textNodes) {
        const matches = [...node.data.matchAll(pattern)];
        if (!matches.length) {
            continue;
        }

        const fragment = document.createDocumentFragment();
        let offset = 0;
        for (const match of matches) {
            fragment.append(node.data.slice(offset, match.index));
            const mark = document.createElement('mark');
            mark.className = 'species-search__match';
            mark.textContent = match[0];
            fragment.append(mark);
            marks.push(mark);
            offset = match.index + match[0].length;
        }
        fragment.append(node.data.slice(offset));
        node.replaceWith(fragment);
    }
}

function speciesMatchExcerpt(value, term, text) {
    const index = text.indexOf(term);
    const matchEnd = index + term.length;
    const start = index > 35 ? value.lastIndexOf(' ', index - 35) + 1 : 0;
    const nextSpace = value.indexOf(' ', matchEnd + 45);
    const end = nextSpace === -1 ? value.length : nextSpace;
    return `${start ? '…' : ''}${value.slice(start, end).trim()}${end < value.length ? '…' : ''}`;
}

document.querySelectorAll('#tx-hgonspecies').forEach((speciesList) => {
    const input = speciesList.querySelector('[data-species-search-input]');
    if (!input) {
        return;
    }

    const normalize = (value) => value.normalize('NFC').toLocaleLowerCase('de');
    const columnLabels = Array.from(speciesList.querySelectorAll('#tx-hgonspecies-list tr:first-child td'),
        (cell) => cell.textContent.replace(/\s+/g, ' ').trim());
    const rows = Array.from(speciesList.querySelectorAll('tr[data-species-search-id]'), (row) => {
        const scientificName = row.querySelector('[data-species-search-scientific]');
        return {
            row,
            scientificName,
            scientificText: normalize(scientificName?.textContent ?? ''),
            cells: Array.from(row.cells, (cell, index) => {
                const value = cell.textContent.replace(/\s+/g, ' ').trim().normalize('NFC');
                return { cell, value, text: normalize(value), label: columnLabels[index] };
            }),
        };
    });
    const tiles = Array.from(speciesList.querySelectorAll('#tx-hgonspecies-overview [data-species-search-id]'), (tile) => ({
        tile,
        names: Array.from(tile.querySelectorAll('[data-species-search-tile-name]'), (name) => ({
            node: name,
            text: normalize(name.textContent),
        })),
        context: tile.querySelector('[data-species-search-tile-context]'),
    }));
    const groups = speciesList.querySelectorAll('[data-species-search-group]');
    const emptyMessages = speciesList.querySelectorAll('[data-species-search-empty]');
    const marks = [];
    let previousQuery;

    const filterSpecies = () => {
        const query = normalize(input.value).trim();
        if (query === previousQuery) {
            return;
        }
        previousQuery = query;

        const markedParents = new Set();
        for (const mark of marks) {
            markedParents.add(mark.parentNode);
            mark.replaceWith(mark.textContent);
        }
        markedParents.forEach((parent) => parent.normalize());
        marks.length = 0;

        const terms = query ? [...new Set(query.split(/\s+/))] : [];
        const escapedTerms = terms.sort((a, b) => b.length - a.length)
            .map((term) => term.replace(/[.*+?^${}()|[\]\\]/g, '\\$&'));
        const pattern = query ? new RegExp(escapedTerms.join('|'), 'giu') : null;
        const matchingRows = new Map();

        for (const { row, scientificName, scientificText, cells } of rows) {
            const matches = terms.every((term) => cells.some(({ text }) => text.includes(term)));
            row.hidden = !matches;
            if (scientificName) {
                scientificName.hidden = !matches || !terms.some((term) => scientificText.includes(term));
            }
            if (!matches) {
                continue;
            }
            matchingRows.set(row.dataset.speciesSearchId, cells);
            for (const { cell, text } of cells) {
                if (pattern && terms.some((term) => text.includes(term))) {
                    highlightSpeciesMatches(cell, pattern, marks);
                }
            }
        }

        for (const { tile, names, context } of tiles) {
            const cells = matchingRows.get(tile.dataset.speciesSearchId);
            tile.hidden = Boolean(query) && !cells;
            context.replaceChildren();
            context.hidden = true;
            if (!pattern || !cells) {
                continue;
            }

            for (const { node, text } of names) {
                if (terms.some((term) => text.includes(term))) {
                    highlightSpeciesMatches(node, pattern, marks);
                }
            }

            const excerpts = [];
            for (const term of terms) {
                if (names.some(({ text }) => text.includes(term)) || excerpts.some((excerpt) => normalize(excerpt).includes(term))) {
                    continue;
                }
                const source = cells.find(({ text }) => text.includes(term));
                const excerpt = speciesMatchExcerpt(source.value, term, source.text);
                excerpts.push(excerpt);

                const item = document.createElement('p');
                item.className = 'species-search__excerpt';
                const text = document.createElement('span');
                text.textContent = excerpt;
                const label = source.label.endsWith('?') ? source.label : `${source.label}:`;
                item.append(`${label} `, text);
                highlightSpeciesMatches(text, pattern, marks);
                context.append(item);
            }
            context.hidden = !excerpts.length;
        }

        for (const group of groups) {
            group.hidden = Boolean(query) && !group.querySelector('[data-species-search-id]:not([hidden])');
            group.previousElementSibling.hidden = group.hidden;
        }

        for (const message of emptyMessages) {
            message.hidden = !query || Boolean(message.parentElement.querySelector('[data-species-search-id]:not([hidden])'));
        }
    };

    speciesList.classList.add('species-search');
    input.addEventListener('input', filterSpecies);
    filterSpecies();
    input.hidden = false;
});
