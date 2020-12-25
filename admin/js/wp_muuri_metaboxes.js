;(function () {
  document.addEventListener('DOMContentLoaded', (e) => {
    /**
     * Add an item to the gallery.
     */
    function muuriAddItemsToGallery() {
      const wpMuuriAddBtn = document.querySelector('#wpMuuriGallery__add')

      if (wpMuuriAddBtn) {
        wpMuuriAddBtn.addEventListener('click', (e) => {
          const wpGalleryImages = wp
            .media({
              title: 'Upload Images',
              multiple: 'add',
            })
            .open()
            .on('select', (e) => {
              const wpGalleryUploadedImages = wpGalleryImages
                .state()
                .get('selection')
              const wpGallerySelectedImages = wpGalleryUploadedImages.toJSON()
              const wpGalleryItems = []
              const wpGalleryImagesSelectedList = document.querySelector(
                '#wpMuuriGallery__list',
              )

              wpGallerySelectedImages.forEach((image) => {
                const imageUrl = image.url
                const imageAlt = image.alt
                const imageCaption = image.caption
                const fileType = image.type
                const imageID = image.id
                const imageTitle = image.title
                // console.log(
                //     {
                //         imageUrl,
                //         imageAlt,
                //         imageCaption,
                //         fileType,
                //         imageID,
                //         imageTitle
                //     });

                const wpGalleryItem = `
                        <li class="wpMuuriGallery__item" data-gallery-item-id="${imageID}">
                            <div class="uk-card uk-card-default uk-card-body uk-padding-remove">
                                <img 
                                    src="${imageUrl}"  
                                    title ="${imageTitle}" 
                                    alt ="${imageAlt}" 
                                    width="150" height="150"/>
                                <button 
                                    data-gallery-item-id="${imageID}" 
                                    class="uk-position-top-right uk-icon-link wpMuuriGallery__removeItem" 
                                    uk-icon="close">
                                </button>
                            </div>
                        </li>`

                wpGalleryItems.push(wpGalleryItem)
              })

              if (wpGalleryImagesSelectedList) {
                wpGalleryImagesSelectedList.insertAdjacentHTML(
                  'afterbegin',
                  wpGalleryItems,
                )
                muuriUpdateGalleryJson()
              }
            })
        })
      }
    }

    /**
     * Deletes an item from the gallery.
     */
    function muuriDeleteItemFromGallery() {
      const wpMuuriGalleryListContainer = document.getElementById(
        'wpMuuriGallery__list',
      )

      if (wpMuuriGalleryListContainer) {
        wpMuuriGalleryListContainer.addEventListener('click', (e) => {
          if (e.target.classList.contains('wpMuuriGallery__removeItem')) {
            const delBtnItemID = e.target.dataset.galleryItemId
            const galleryItem = e.target.parentNode.parentNode
            if (
              galleryItem.classList.contains('wpMuuriGallery__item') &&
              galleryItem.dataset.galleryItemId === delBtnItemID
            ) {
              wpMuuriGalleryListContainer.removeChild(galleryItem)
            }
          }
        })
      }
    }

    /**
     * Collects the current items in the gallery and their order to update the json value of the hidden field.
     */
    function muuriUpdateGalleryJson() {
      const muuriHiddenInput = document.getElementById(
        'wpMuuriGallery__galleryInputHidden',
      )

      if (muuriHiddenInput) {
        const currentItemsInList = [
          ...document.getElementsByClassName('wpMuuriGallery__item'),
        ]

        const updatedRawData = []

        if (currentItemsInList && currentItemsInList.length > 0) {
          currentItemsInList.forEach((item) => {
            //> extract dataset id
            const itemID = item.dataset.galleryItemId

            //> extract img data
            const itemImg = item.querySelector('img')
            const itemSrc = itemImg.src
            const itemTitle = itemImg.title
            const itemAlt = itemImg.alt

            const computedItem = {
              id: itemID,
              src: itemSrc,
              title: itemTitle,
              alt: itemAlt,
            }

            updatedRawData.push(computedItem)
          })

          muuriHiddenInput.innerHTML = JSON.stringify(updatedRawData)
        }
      }
    }

    /**
     * Checks if there's been an update to the gallery items position and number and updates the JSON value of the hidden input field.
     */
    function muuriUpdateGalleryJsonOnItemDrag() {
      const wpMuuriGalleryListContainer = document.getElementById(
        'wpMuuriGallery__list',
      )

      if (wpMuuriGalleryListContainer) {
        const observerCfg = { attributes: true, childList: true, subtree: true }

        const observerObj = new MutationObserver((mutationList, observer) => {
          for (const mutation of mutationList) {
            if (mutation.type === 'childList') {
              muuriUpdateGalleryJson()
            }
          }
        })

        observerObj.observe(wpMuuriGalleryListContainer, observerCfg)
        // observerObj.disconnect();
      }
    }

    muuriAddItemsToGallery()
    muuriDeleteItemFromGallery()
    muuriUpdateGalleryJsonOnItemDrag()
  })
})()
