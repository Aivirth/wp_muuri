<?php

class Wp_Muuri_cpt_fields
{
    public function css_selectors(): array
    {
        return [
            [
                'name' => 'muuriContainerClass',
                'label' => 'Container',
                'type' => 'text',
                'default' => 'muuri',
            ],
            [
                'name' => 'muuriItemClass',
                'label' => 'Item',
                'type' => 'text',
                'default' => 'muuri-item',
            ],
            [
                'name' => 'muuriItemVisibleClass',
                'label' => 'Item Visible',
                'type' => 'text',
                'default' => 'muuri-item-shown',
            ],
            [
                'name' => 'muuriItemHiddenClass',
                'label' => 'Item Hidden',
                'type' => 'text',
                'default' => 'muuri-item-hidden',
            ],
            [
                'name' => 'muuriItemPositioningClass',
                'label' => 'Show Duration',
                'type' => 'text',
                'default' => 'muuri-item-positioning',
            ],
            [
                'name' => 'muuriItemDraggingClass',
                'label' => 'Item Dragging',
                'type' => 'text',
                'default' => 'muuri-item-dragging',
            ],
            [
                'name' => 'muuriItemReleasingClass',
                'label' => 'Item Releasing',
                'type' => 'text',
                'default' => 'muuri-item-releasing',
            ],
            [
                'name' => 'muuriItemPlaceholderClass',
                'label' => 'Item Placeholder',
                'type' => 'text',
                'default' => 'muuri-item-placeholder',
            ],
        ];
    }

    public function animations(): array
    {
        return [
            [
                'name' => 'muuriShowDuration',
                'label' => 'Show Duration',
                'type' => 'number',
                'default' => 300,
            ],
            [
                'name' => 'muuriShowEasing',
                'label' => 'Show Easing',
                'type' => 'select',
                'default' => 'ease',
                'options' => [
                    'ease' => 'Ease',
                    'ease-in-out' => 'Ease In Out',
                ],
            ],
        ];
    }

    public function layout(): array
    {
        return [
            [
                'name' => 'muuriHideDuration',
                'label' => 'Hide Duration',
                'type' => 'number',
                'default' => 300,
                'min' => 0,
            ],
            [
                'name' => 'muuriHideEasing',
                'label' => 'Hide Easing',
                'type' => 'select',
                'default' => 'ease',
                'options' => [
                    'ease' => 'Ease',
                    'ease-in-out' => 'Ease In Out',
                ],
            ],
            [
                'name' => 'muuriLayoutFillGaps',
                'label' => 'Fill Gaps',
                'type' => 'radio',
                'default' => 0,
                'options' => [
                    '0' => 'No',
                    '1' => 'Yes',
                ],
            ],
            [
                'name' => 'muuriLayoutIsHorizontal',
                'label' => 'Horizontal Layout',
                'type' => 'radio',
                'default' => 0,
                'options' => [
                    '0' => 'No',
                    '1' => 'Yes',
                ],
            ],
            [
                'name' => 'muuriLayoutAlignRight',
                'label' => 'Align Right',
                'type' => 'radio',
                'default' => 0,
                'options' => [
                    '0' => 'No',
                    '1' => 'Yes',
                ],
            ],
            [
                'name' => 'muuriLayoutAlignBottom',
                'label' => 'Align Bottom',
                'type' => 'radio',
                'default' => 0,
                'options' => [
                    '0' => 'No',
                    '1' => 'Yes',
                ],
            ],
            [
                'name' => 'muuriLayoutRounding',
                'label' => 'Rounding',
                'type' => 'radio',
                'default' => 0,
                'options' => [
                    '0' => 'No',
                    '1' => 'Yes',
                ],
            ],
            [
                'name' => 'muuriLayoutOnResize',
                'label' => 'Layout on Resize ?',
                'type' => 'radio',
                'default' => 0,
                'options' => [
                    '0' => 'No',
                    '1' => 'Yes',
                ],
            ],
            [
                'name' => 'muuriLayoutOnInit',
                'label' => 'Layout on Init ?',
                'type' => 'radio',
                'default' => 0,
                'options' => [
                    '0' => 'No',
                    '1' => 'Yes',
                ],
            ],
            [
                'name' => 'muuriLayoutDuration',
                'label' => 'Layout duration',
                'type' => 'number',
                'default' => 300,
                'min' => 0,
            ],
            [
                'name' => 'muuriLayoutEasing',
                'label' => 'Layout Easing',
                'type' => 'select',
                'default' => 'ease',
                'options' => [
                    'ease' => 'Ease',
                    'ease-in-out' => 'Ease In Out',
                ],
            ],
        ];
    }

    public function drag_basic(): array
    {
        return [
            [
                'name' => 'muuriDragEnabled',
                'label' => 'Should items be draggable?',
                'type' => 'radio',
                'default' => 0,
                'options' => [
                    '0' => 'No',
                    '1' => 'Yes',
                ],
            ],
            [
                'name' => 'muuriDragContainer',
                'label' => 'Drag Container',
                'type' => 'text',
                'default' => '',
            ],
            [
                'name' => 'muuriDragHandle',
                'label' => 'Drag Handle',
                'type' => 'text',
                'default' => '',
            ],
            [
                'name' => 'muuriDragAxis',
                'label' => 'Drag Axis',
                'type' => 'select',
                'default' => 'ease',
                'options' => [
                    'xy' => 'XY',
                    'x' => 'X',
                    'y' => 'Y',
                ],
            ],
            [
                'name' => 'muuriDragSort',
                'label' => 'Should the items be sorted during drag?',
                'type' => 'radio',
                'default' => 0,
                'options' => [
                    '0' => 'No',
                    '1' => 'Yes',
                ],
            ],
        ];
    }

    public function drag_predicate(): array
    {
        return [
            [
                'name' => 'muuriDragSortPredicate__threshold',
                'label' => 'Threshold',
                'type' => 'number',
                'default' => 50,
                'min' => 1,
                'max' => 100,
            ],
            [
                'name' => 'muuriDragSortPredicate__action',
                'label' => 'Action',
                'type' => 'select',
                'default' => 'move',
                'options' => [
                    'move' => 'Move',
                    'swap' => 'Swap',
                ],
            ],
            [
                'name' => 'muuriDragSortPredicate__migrateAction',
                'label' => 'Migrate Action',
                'type' => 'select',
                'default' => 'move',
                'options' => [
                    'move' => 'Move',
                    'swap' => 'Swap',
                ],
            ],
        ];
    }

    public function drag_release(): array
    {
        return [
            [
                'name' => 'muuriDragRelease__duration',
                'label' => 'Duration',
                'type' => 'number',
                'default' => 300,
                'min' => 0,
            ],
            [
                'name' => 'muuriDragRelease__easing',
                'label' => 'Easing',
                'type' => 'select',
                'default' => 'ease',
                'options' => [
                    'linear' => 'Linear',
                    'ease' => 'Ease',
                    'ease-in' => 'Ease In',
                    'ease-out' => 'Ease Out',
                    'ease-in-out' => 'Ease In Out',
                    'cubic_bezier__1' => 'Cubic-bezier(0.25, 0.1, 0.25, 1)',
                ],
            ],
            [
                'name' => 'muuriDragRelease__useDragContainer',
                'label' => 'Use Drag container during release?',
                'type' => 'radio',
                'default' => '1',
                'options' => [
                    '0' => 'No',
                    '1' => 'Yes',
                ],
            ],
        ];
    }

    public function drag_cssProps(): array
    {
        return [
            [
                'name' => 'muuriDragCssProps__touchAction',
                'label' => 'Touch Action',
                'type' => 'select',
                'default' => 'none',
                'options' => [
                    'auto' => 'Auto',
                    'none' => 'None',
                    'pan-x' => 'Pan X',
                    'pan-left' => 'Pan Left',
                    'pan-right' => 'Pan Right',
                    'pan-y' => 'Pan Y',
                    'pan-up' => 'Pan Up',
                    'pan-down' => 'Pan Down',
                    'pinch-zoom' => 'Pinch Zoom',
                    'manipulation' => 'Manipulation',
                    'inherit' => 'Inherit',
                    'initial' => 'Initial',
                    'unset' => 'Unset',
                ],
            ],
            [
                'name' => 'muuriDragCssProps__userSelect',
                'label' => 'User Select',
                'type' => 'select',
                'default' => 'none',
                'options' => [
                    'auto' => 'Auto',
                    'none' => 'None',
                    'text' => 'Text',
                    'contain' => 'Contain',
                    'all' => 'All',
                    'inherit' => 'Inherit',
                    'initial' => 'Initial',
                    'unset' => 'Unset',
                ],
            ],
            [
                'name' => 'muuriDragCssProps__userDrag',
                'label' => 'User Drag',
                'type' => 'select',
                'default' => 'none',
                'options' => [
                    'auto' => 'Auto',
                    'none' => 'None',
                    'element' => 'Element',
                    'inherit' => 'Inherit',
                ],
            ],
            // [
            //     'name' => 'muuriDragCssProps__tapHighlightColor',
            //     'label' => 'Tap Highlight color',
            //     'type' => 'color',
            //     'default' => 'rgba(0, 0, 0, 0)',
            // ],
        ];
    }

    public function styles(): array
    {
        return [
            [
                'name' => 'muuriVisibleStyles__opacity',
                'label' => 'Gallery item visible state opacity style',
                'type' => 'number',
                'default' => 1,
                'min' => 0,
                'max' => 1,
                'step' => 0.1,
            ],
            [
                'name' => 'muuriVisibleStyles__transform',
                'label' => 'Gallery item visible state transform property',
                'type' => 'text',
                'default' => 'scale(1)',
            ],
            [
                'name' => 'muuriHiddenStyles__opacity',
                'label' => 'Gallery item hidden state opacity style',
                'type' => 'number',
                'default' => 0,
                'min' => 0,
                'max' => 1,
                'step' => 0.1,
            ],
            [
                'name' => 'muuriHiddenStyles__transform',
                'label' => 'Gallery item hidden state transform property',
                'type' => 'text',
                'default' => 'scale(0.5)',
            ],
        ];
    }
}
