document.addEventListener('DOMContentLoaded', function () {
    const muuriGridEls = [...document.getElementsByClassName('grid')];

    const MuuriInstances = [];

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

    /*
    muuriDragAxis: "xy"
    muuriDragContainer: null
    muuriDragCssProps__touchAction: "none"
    muuriDragCssProps__userDrag: "none"
    muuriDragCssProps__userSelect: "none"
    muuriDragEnabled: null
    muuriDragHandle: null
    muuriDragRelease__duration: "300"
    muuriDragRelease__easing: "ease"
    muuriDragRelease__useDragContainer: null
    muuriDragSort: null
    muuriDragSortPredicate__action: "move"
    muuriDragSortPredicate__migrateAction: "move"
    muuriDragSortPredicate__threshold: "50"
    muuriGalleryItems: "[{"id":"66","src":"http://localhost/wp-content/uploads/2020/12/80851625_p0.jpg","title":"80851625_p0","alt":""},{"id":"67","src":"http://localhost/wp-content/uploads/2020/12/80939886_p0.jpg","title":"80939886_p0","alt":""}]"
    muuriHideDuration: "300"
    muuriHideEasing: "ease"
    muuriLayoutAlignBottom: null
    muuriLayoutAlignRight: null
    muuriLayoutDuration: "300"
    muuriLayoutEasing: "ease"
    muuriLayoutFillGaps: null
    muuriLayoutIsHorizontal: null
    muuriLayoutOnInit: null
    muuriLayoutOnResize: null
    muuriLayoutRounding: null
    muuriShowDuration: "301"
    muuriShowEasing: "ease"
    _edit_last: "1"
    _edit_lock: "1609016836"
    */

    if (muuriGridEls && muuriGridEls.length > 0) {
        muuriGridEls.forEach((gallery, index) => {
            const currGalleryCfg = wp_muuri_cfg_obj;

            const muuriOptions = loadMuuriOptions(currGalleryCfg);

            MuuriInstances[`gallery__${index}`] = new Muuri(
                '.grid',
                muuriOptions
            );

            console.log(MuuriInstances[`gallery__${index}`]);
            MuuriInstances[`gallery__${index}`].refreshItems().layout();
            gallery.classList.add('images-loaded');
        });

        // const galleries = muuriGridEls.getElementsByClassName('item');
        // if (Array.isArray(galleries) && galleries.length > 0) {
        //     const MuuriInstances = [];

        //     galleries.forEach((item) => {
        //         const imageID = item.dataset.wp_muuri_gallery_item_id;

        //         MuuriInstances['g']
        //         const gallery = 1;
        //     });

        //     const grid = new Muuri('.grid');
        // }
    }

    // console.log(MuuriInstances);
});
