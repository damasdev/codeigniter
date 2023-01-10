<?php

class MenuLibrary
{
    /**
     * Tag opener of the navigation menu
     * default is '<ul>' tag
     *
     * @var string
     */
    private $navTagOpen = '<ul class="navbar-nav pt-lg-3">';

    /**
     * Closing tag of the navigation menu
     * default is '</ul>'
     *
     * @var string
     */
    private $navTagClose = '</ul>';

    /**
     * Tag opening tag of the menu item
     * default is '<div>'
     *
     * @var string
     */
    private $itemTagOpen = '';

    /**
     * Closing tag of the menu item
     * default is '</li>'
     *
     * @var string
     */
    private $itemTagClose = '';

    /**
     * Opening tag of the menu item that has children
     * default is '</li>'
     *
     * @var string
     */
    private $parentTagOpen = '<li class="nav-item">';

    /**
     * Closing tag of the menu item that has children
     * default is '</li>'
     *
     * @var string
     */
    private $parentTagClose = '</li>';

    /**
     * Anchor tag of the menu item that has children
     * default is '<a href="%s">%s</a>'
     *
     * @var string
     */
    private $parentAnchor = '<span data-info="%s" class="nav-link dropdown-toggle" data-bs-toggle="dropdown" data-bs-auto-close="false" role="button" aria-expanded="false">%s</span>';

    /**
     * Opening tag of the children menu / sub menu.
     * Default is '<ul>'
     *
     * @var string
     */
    private $childrenTagOpen = '<div class="dropdown-menu"><div class="dropdown-menu-columns">';

    /**
     * Closing tag of the children menu / sub menu.
     * Default is '<div>'
     *
     * @var string
     */
    private $childrenTagClose = '</div></div>';

    /**
     * iconTagOpen
     *
     * @var string
     */
    private $iconTagOpen = '<span class="nav-link-icon d-md-none d-lg-inline-block">';

    /**
     * iconTagClose
     *
     * @var string
     */
    private $iconTagClose = '</span>';

    /**
     * Anchor tag of the menu item.
     * Default is '<a href="%s">%s</a>'
     *
     * @var string
     */
    private $itemAnchor = '<a href="%s" class="nav-link">%s</a>';

    /**
     * childrenItemAnchor
     *
     * @var string
     */
    private $childrenItemAnchor = '<a href="%s" class="dropdown-item">%s</a>';

    /**
     * items
     *
     * @var array
     */
    private $items = [];

    public function __construct()
    {
        $this->load->model('menu/Menu_model', 'menuModel');
    }

    /**
     * __get
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

    public function initialize()
    {
        $conditions = [];
        $user = $this->session->userdata('user') ?? null;
        if ($user) {
            $conditions = $user->type === 'admin' ? [] : [
                'role_id' => $user->role_id
            ];
        }

        $result = $this->menuModel->allWithAcl($conditions);

        $this->items = toArray($result);
    }

    public function render()
    {
        $html  = "";
        $this->initialize();

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
            if ($item['parent'] == $parent) {
                $items[$item['id']] = $item;
                $items[$item['id']]['children'] = $this->prepareItems($data, $item['id']);
            }
        }

        usort($items, array($this, 'sortByOrder'));

        return $items;
    }

    private function sortByOrder($a, $b)
    {
        return $a['number'] - $b['number'];
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
            $slug  = $item['slug'] ?? null;
            $icon  = $item['icon'] ?? '';
            $label  = $item['name'] ?? '';

            // has children or not
            $has_children = !empty($item['children']);
            $has_parent = !empty($item['parent']);

            if ($icon) {
                $icon = "{$this->iconTagOpen}<i class='icon {$icon}'></i>{$this->iconTagClose}";
                $label = trim($icon . "<span class='nav-link-title'>{$label}</span>");
            }

            if ($has_children) {
                $tag_open     = $this->parentTagOpen;
                $itemAnchor = $this->parentAnchor;
                $href  = '#';
            } else {
                $tag_open    = $has_parent ? $this->itemTagOpen : $this->parentTagOpen;
                $href        = site_url($slug);
                $itemAnchor = $has_parent ? $this->childrenItemAnchor : $this->itemAnchor;
            }

            $html  .= $tag_open ? $this->setActive($tag_open, $slug) : $tag_open;
            $itemAnchor = $this->setActive($itemAnchor, $slug);

            if (substr_count($itemAnchor, '%s') == 2) {
                $html .= sprintf($itemAnchor, $href, $label);
            } else {
                $html .= sprintf($itemAnchor, $label);
            }

            if ($has_children) {
                $this->renderItem($item['children'], $html);
                $html  .= $this->parentTagClose;
            } else {
                $html .= $this->itemTagClose;
            }
        }

        if (isset($navTagOpened)) {
            $html .= $this->navTagClose;
        } else {
            $html  .= $this->childrenTagClose;
        }
    }

    private function setActive(&$html, $slug)
    {
        $segment = $this->uri->segment(1);

        if ($slug == $segment) {
            $doc = new DOMDocument();
            $doc->loadHTML($html);

            foreach ($doc->getElementsByTagName('*') as $tag) {
                $tag->setAttribute('class', $tag->getAttribute('class') . ' active');
            }

            $html = $doc->saveHTML();
        }

        return $html;
    }
}
