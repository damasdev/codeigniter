<?php defined('BASEPATH') or exit('No direct script access allowed');

class MenuLibrary
{

    /**
     * Tag opener of the navigation menu
     * default is '<ul>' tag
     * 
     * @var string
     */
    private $nav_tag_open             = '<ul class="navbar-nav pt-lg-3">';

    /**
     * Closing tag of the navigation menu
     * default is '</ul>'
     * 
     * @var string
     */
    private $nav_tag_close            = '</ul>';

    /**
     * Tag opening tag of the menu item
     * default is '<div>'
     * 
     * @var string
     */
    private $item_tag_open            = '';

    /**
     * Closing tag of the menu item
     * default is '</li>'
     * 
     * @var string
     */
    private $item_tag_close           = '';

    /**
     * Opening tag of the menu item that has children
     * default is '</li>'
     * 
     * @var string
     */
    private $parent_tag_open          = '<li class="nav-item">';

    /**
     * Closing tag of the menu item that has children
     * default is '</li>'
     * 
     * @var string
     */
    private $parent_tag_close         = '</li>';

    /**
     * Anchor tag of the menu item that has children
     * default is '<a href="%s">%s</a>'
     * 
     * @var string
     */
    private $parent_anchor            = '<span data-info="%s" class="nav-link dropdown-toggle" data-bs-toggle="dropdown" data-bs-auto-close="false" role="button" aria-expanded="false">%s</span>';

    /**
     * Opening tag of the children menu / sub menu.
     * Default is '<ul>'
     * 
     * @var string
     */
    private $children_tag_open        = '<div class="dropdown-menu"><div class="dropdown-menu-columns">';

    /**
     * Closing tag of the children menu / sub menu.
     * Default is '<div>'
     * 
     * @var string
     */
    private $children_tag_close       = '</div></div>';

    /**
     * icon_tag_open
     *
     * @var string
     */
    private $icon_tag_open            = '<span class="nav-link-icon d-md-none d-lg-inline-block">';

    /**
     * icon_tag_close
     *
     * @var string
     */
    private $icon_tag_close           = '</span>';

    /**
     * Anchor tag of the menu item.
     * Default is '<a href="%s">%s</a>'
     * 
     * @var string
     */
    private $item_anchor              = '<a href="%s" class="nav-link">%s</a>';

    /**
     * children_item_anchor
     *
     * @var string
     */
    private $children_item_anchor     = '<a href="%s" class="dropdown-item">%s</a>';

    public function __construct()
    {
        $this->load->model('menu/MenuModel', 'menuModel');
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
        $user = $this->session->userdata('user') ?? NULL;
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
        $items = array();

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
            $nav_tag_opened = true;
            $html .= $this->nav_tag_open;
        } else {
            $html .= $this->children_tag_open;
        }

        foreach ($items as $item) {

            $slug  = $item['slug'] ?? NULL;
            $icon  = $item['icon'] ?? '';
            $label  = $item['name'] ?? '';

            // has children or not
            $has_children = !empty($item['children']);
            $has_parent = !empty($item['parent']);

            if ($icon) {
                $icon = "{$this->icon_tag_open}<i class='icon {$icon}'></i>{$this->icon_tag_close}";
                $label = trim($icon . "<span class='nav-link-title'>{$label}</span>");
            }

            if ($has_children) {
                $tag_open     = $this->parent_tag_open;
                $item_anchor = $this->parent_anchor;
                $href  = '#';
            } else {
                $tag_open    = $has_parent ? $this->item_tag_open : $this->parent_tag_open;
                $href        = site_url($slug);
                $item_anchor = $has_parent ? $this->children_item_anchor : $this->item_anchor;
            }

            $html  .= $tag_open ? $this->setActive($tag_open, $slug) : $tag_open;
            $item_anchor = $this->setActive($item_anchor, $slug);

            if (substr_count($item_anchor, '%s') == 2) {
                $html .= sprintf($item_anchor, $href, $label);
            } else {
                $html .= sprintf($item_anchor, $label);
            }

            if ($has_children) {
                $this->renderItem($item['children'], $html);
                $html  .= $this->parent_tag_close;
            } else {
                $html .= $this->item_tag_close;
            }
        }

        if (isset($nav_tag_opened)) {
            $html .= $this->nav_tag_close;
        } else {
            $html  .= $this->children_tag_close;
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
