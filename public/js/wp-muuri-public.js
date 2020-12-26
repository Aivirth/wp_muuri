document.addEventListener('DOMContentLoaded', function () {
    const muuriGridEls = [...document.getElementsByClassName('grid')];

    console.log('test_fetch');
    const MuuriInstances = [];
    console.log(muuriGridEls);

    if (muuriGridEls && muuriGridEls.length > 0) {
        console.log('test_if');
        muuriGridEls.forEach((gallery, index) => {
            MuuriInstances[`gallery__${index}`] = new Muuri('.grid');
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

    console.log(MuuriInstances);
});
