<?php

namespace Mayahkw\CMS;


use Inertia\Inertia;
use Mayahkw\CMS\Models\CmsTheme;
use Mayahkw\CMS\Models\CmsThemeBlock;

class MyCmsClass
{
    public $routeName;

    public function __construct($routeName = '', $editMenu = false)
    {
        $this->routeName = $routeName;
    }


    public function page($data = [])
    {
        return Inertia::render('My/Admin/Components/Layout', $data);
    }

    public function getTheme($theme)
    {
        $theme = CmsTheme::find($theme);

        $theme->blocks = $this->getBlocks($theme->id, null);
        // dd($blocks);
        return $theme;
    }

    public function getBlocks($theme, $nivel)
    {

        $blocks = CmsThemeBlock::where('theme_id', $theme)->where('parent_id', $nivel)->get();

        foreach ($blocks as $block) {
            if (json_decode($block->value) != null) {
                $block->value = json_decode($block->value);
            }

            $block->operators = json_decode($block->operators);
            $block->options = json_decode($block->options);
            $block->blocks = $this->getBlocks($theme, $block->id);
            $block->parent = $this->getParents($theme, $block->parent_id);
            $block->block->options = json_decode($block->block->options);
            if (json_decode($block->block->value) != null) {
                $block->block->value = json_decode($block->block->value);
            }
        }
        return $blocks;
    }

    public function getParents($theme, $nivel)
    {
        $block = CmsThemeBlock::where('theme_id', $theme)->where('id', $nivel)->first();
        if ($block) {
            $block->parent = $this->getParents($theme, $block->parent_id);
        }
        return $block;
    }
}
