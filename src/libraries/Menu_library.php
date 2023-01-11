<?php

class Menu_library
{
    /**
     * Tag opener of the navigation menu
     * default is '<ul>' tag.
     *
     * @var string
     */
    private $navTagOpen = '<ul class="navbar-nav pt-lg-3">';

    /**
     * Closing tag of the navigation menu
     * default is '</ul>'.
     *
     * @var string
     */
    private $navTagClose = '</ul>';

    /**
     * Tag opening tag of the menu item
     * default is '<div>'.
     *
     * @var string
     */
    private $itemTagOpen = '';

    /**
     * Closing tag of the menu item
     * default is '</li>'.
     *
     * @var string
     */
    private $itemTagClose = '';

    /**
     * Opening tag of the menu item that has children
     * default is '</li>'.
     *
     * @var string
     */
    private $parentTagOpen = '<li class="nav-item">';

    /**
     * Closing tag of the menu item that has children
     * default is '</li>'.
     *
     * @var string
     */
    private $parentTagClose = '</li>';

    /**
     * Anchor tag of the menu item that has children
     * default is '<a href="%s">%s</a>'.
     *
     * @var string
     */
    private $parentAnchor = '<span data-info="%s" class="nav-link dropdown-toggle" data-bs-toggle="dropdown" data-bs-auto-close="false" role="button" aria-expanded="false">%s</span>';

    /**
     * Opening tag of the children menu / sub menu.
     * Default is '<ul>'.
     *
     * @var string
     */
    private $childrenTagOpen = '<div class="dropdown-menu"><div class="dropdown-menu-columns">';

    /**
     * Closing tag of the children menu / sub menu.
     * Default is '<div>'.
     *
     * @var string
     */
    private $childrenTagClose = '</div></div>';

    /**
     * iconTagOpen.
     *
     * @var string
     */
    private $iconTagOpen = '<span class="nav-link-icon d-md-none d-lg-inline-block">';

    /**
     * iconTagClose.
     *
     * @var string
     */
    private $iconTagClose = '</span>';

    /**
     * Anchor tag of the menu item.
     * Default is '<a href="%s">%s</a>'.
     *
     * @var string
     */
    private $itemAnchor = '<a href="%s" class="nav-link">%s</a>';

    /**
     * childrenItemAnchor.
     *
     * @var string
     */
    private $childrenItemAnchor = '<a href="%s" class="dropdown-item">%s</a>';

    /**
     * items.
     *
     * @var array
     */
    private $items = [];

    /**
     * __get.
     *
     * Enables the use of CI super-global without having to define an extra variable.
     *
     * @param string $var
     *
     * @return mixed
     */
    public function __get($var)
    {
        return get_instance()->$var;
    }

    public function render(?string $role)
    {
        $html = '';
        $items = $this->config->item('menus');
        foreach ($items as $index => $value) {
            if (!in_array($role, $value['privileges'])) {
                unset($items[$index]);
            }
        }

        $this->items = $items;

        if (count($this->items)) {
            $items = $this->prepareItems($this->items);

            $this->renderItem($items, $html);
        }

        return $html;
    }

    private function prepareItems(array $data, $parent = null)
    {
        $items = [];

        foreach ($data as $item) {
            if ($item['parent'] === $parent) {
                $items[$item['id']] = $item;
                $items[$item['id']]['children'] = $this->prepareItems($data, $item['id']);
            }
        }

        return $items;
    }

    private function renderItem($items, &$html = '')
    {
        if (empty($html)) {
            $navTagOpened = true;
            $html .= $this->navTagOpen;
        } else {
            $html .= $this->childrenTagOpen;
        }

        foreach ($items as $item) {
            $slug = $item['slug'] ?? null;
            $icon = $item['icon'] ?? '';
            $label = $item['title'] ?? '';

            // has children or not
            $hasChildren = !empty($item['children']);
            $hasParent = !empty($item['parent']);

            if ($icon) {
                $icon = "{$this->iconTagOpen}<i class='icon {$icon}'></i>{$this->iconTagClose}";
                $label = trim($icon."<span class='nav-link-title'>{$label}</span>");
            }

            if ($hasChildren) {
                $tagOpen = $this->parentTagOpen;
                $itemAnchor = $this->parentAnchor;
                $href = '#';
            } else {
                $tagOpen = $hasParent ? $this->itemTagOpen : $this->parentTagOpen;
                $href = site_url($slug);
                $itemAnchor = $hasParent ? $this->childrenItemAnchor : $this->itemAnchor;
            }

            $html .= $tagOpen ? $this->setActive($tagOpen, $slug) : $tagOpen;
            $itemAnchor = $this->setActive($itemAnchor, $slug);

            if (substr_count($itemAnchor, '%s') === 2) {
                $html .= sprintf($itemAnchor, $href, $label);
            } else {
                $html .= sprintf($itemAnchor, $label);
            }

            if ($hasChildren) {
                $this->renderItem($item['children'], $html);
                $html .= $this->parentTagClose;
            } else {
                $html .= $this->itemTagClose;
            }
        }

        if (isset($navTagOpened)) {
            $html .= $this->navTagClose;
        } else {
            $html .= $this->childrenTagClose;
        }
    }

    private function setActive(&$html, $slug)
    {
        $segment = $this->uri->segment(1);

        if ($slug === $segment) {
            $doc = new DOMDocument();
            $doc->loadHTML($html);

            foreach ($doc->getElementsByTagName('*') as $tag) {
                $tag->setAttribute('class', $tag->getAttribute('class').' active');
            }

            $html = $doc->saveHTML();
        }

        return $html;
    }
}
