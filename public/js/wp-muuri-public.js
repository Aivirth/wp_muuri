/**
 * Global object for storing Muuri instances.
 */
const WP_Muuri = (function () {
    /**
     * Stores Muuri instances present in the current page.
     */
    const MuuriInstances = [];

    /**
     * Overrides Muuri default params with customs.
     * @param {*} optionsObj
     */
    const loadMuuriOptions = (optionsObj) => {
        const optionsObjParsed = {};

        for (const option in optionsObj) {
            //> check is property is a string number
            const currValue = optionsObj[option];
            optionsObjParsed[option] = isNaN(+currValue)
                ? currValue
                : +currValue;
        }

        const muuriOptions = {
            // Initial item elements
            items: '*',

            // Default show animation
            showDuration: optionsObjParsed.muuriShowDuration,
            showEasing: optionsObjParsed.muuriShowEasing,

            // Default hide animation
            hideDuration: optionsObjParsed.muuriHideDuration,
            hideEasing: 'ease',

            // Item's visible/hidden state styles
            visibleStyles: {
                opacity: '1',
                transform: 'scale(1)',
            },
            hiddenStyles: {
                opacity: '0',
                transform: 'scale(0.5)',
            },

            // Layout
            layout: {
                fillGaps: optionsObjParsed.muuriLayoutFillGaps,
                horizontal: optionsObjParsed.muuriLayoutIsHorizontal,
                alignRight: optionsObjParsed.muuriLayoutAlignRight,
                alignBottom: optionsObjParsed.muuriLayoutAlignBottom,
                rounding: optionsObjParsed.muuriLayoutRounding,
            },
            layoutOnResize: optionsObjParsed.muuriLayoutOnResize,
            layoutOnInit: optionsObjParsed.muuriLayoutOnInit,
            layoutDuration: optionsObjParsed.muuriLayoutDuration,
            layoutEasing: optionsObjParsed.muuriLayoutEasing,

            // Sorting
            sortData: null,

            // Drag & Drop
            dragEnabled: optionsObjParsed.muuriDragEnabled,
            dragContainer: null,
            dragHandle: null,
            dragStartPredicate: {
                distance: 0,
                delay: 0,
            },
            dragAxis: optionsObjParsed.muuriDragAxis,
            dragSort: optionsObjParsed.muuriDragSort,
            dragSortHeuristics: {
                sortInterval: 100,
                minDragDistance: 10,
                minBounceBackAngle: 1,
            },
            dragSortPredicate: {
                threshold: 50,
                action: 'move',
                migrateAction: 'move',
            },
            dragRelease: {
                duration: 300,
                easing: 'ease',
                useDragContainer: true,
            },
            dragCssProps: {
                touchAction: 'none',
                userSelect: 'none',
                userDrag: 'none',
                tapHighlightColor: 'rgba(0, 0, 0, 0)',
                touchCallout: 'none',
                contentZooming: 'none',
            },
            dragPlaceholder: {
                enabled: false,
                createElement: null,
                onCreate: null,
                onRemove: null,
            },
            dragAutoScroll: {
                targets: [],
                handle: null,
                threshold: 50,
                safeZone: 0.2,
                // speed: Muuri.AutoScroller.smoothSpeed(1000, 2000, 2500),
                sortDuringScroll: true,
                smoothStop: false,
                onStart: null,
                onStop: null,
            },

            // Classnames
            containerClass: 'muuri',
            itemClass: 'muuri-item',
            itemVisibleClass: 'muuri-item-shown',
            itemHiddenClass: 'muuri-item-hidden',
            itemPositioningClass: 'muuri-item-positioning',
            itemDraggingClass: 'muuri-item-dragging',
            itemReleasingClass: 'muuri-item-releasing',
            itemPlaceholderClass: 'muuri-item-placeholder',
        };

        return muuriOptions;
    };

    /**
     * Public exposed method.
     *
     * Searches all page for supplied classes and initializes Muuri instances.
     */
    const init = (cNameSelector) => {
        const muuriGridEls = [
            ...document.getElementsByClassName(cNameSelector),
        ];
        if (muuriGridEls && muuriGridEls.length > 0) {
            muuriGridEls.forEach((gallery, index) => {
                const currGalleryCfg = wp_muuri_cfg_obj;

                const muuriOptions = loadMuuriOptions(currGalleryCfg);

                MuuriInstances[`gallery__${index}`] = new Muuri(
                    '.grid',
                    muuriOptions
                );
                MuuriInstances[`gallery__${index}`].refreshItems().layout();
                gallery.classList.add('images-loaded');
            });
        }
    };

    return {
        init: init,
        instances: MuuriInstances,
    };
})();

/**
 * Global object storing the filter functionality of Muuri.
 */
const WP_Muuri_filters = (function (WP_Muuri) {
    /**
     * Public exposed method.
     */
    const init = () => {
        const grids = WP_Muuri.instances;

        /**
         * Calls Muuri.filter.
         *
         * Checks current select value against image tags.
         * @param {*} e
         * @param {*} muuriObj
         */
        const gridFilter = (e, muuriObj) => {
            const currValue = e.target.value;
            muuriObj.filter((item) => {
                const itemTags = item.getElement().querySelector('img').dataset
                    .tags;

                const parsedTags = itemTags.split('|');
                return parsedTags.includes(currValue);
            });
        };

        for (const grid in grids) {
            if (Object.hasOwnProperty.call(grids, grid)) {
                const gridWrapper = grids[grid]._element.parentElement;

                const filterField = gridWrapper.querySelector(
                    '.WP_Muuri__filter'
                );

                filterField.addEventListener(
                    'change',
                    (e) => {
                        gridFilter(e, grids[grid]);
                    },
                    false
                );
            }
        }
    };

    return {
        init: init,
    };
})(WP_Muuri);

document.addEventListener('DOMContentLoaded', function () {
    WP_Muuri.init('grid');
    WP_Muuri_filters.init();
});
