<?php

namespace Log1x\Navi;

class Navi
{
    /**
     * The current menu object.
     *
     * @var mixed
     */
    protected $menu;

    /**
     * All of the menu items.
     *
     * @var array
     */
    protected $items = [];

    /**
     * Create a new Navi.
     *
     * @param  array|object  $attributes
     * @return void
     */
    public function __construct($attributes = [])
    {
        foreach ($attributes as $key => $value) {
            $this->items[$key] = $value;
        }
    }

    /**
     * Get an array of the menu items on this instance.
     *
     * @return array
     */
    public function getItems()
    {
        return $this->items;
    }

    /**
     * Build and assign the navigation menu items.
     *
     * @param  int|string|WP_Term $menu
     * @return $this
     */
    public function build($menu = 'primary_navigation')
    {
        if (is_string($menu)) {
            $menu = get_nav_menu_locations()[$menu] ?? $menu;
        }

        $this->menu = wp_get_nav_menu_object($menu);

        $this->items = (new Builder())->build(
            wp_get_nav_menu_items($this->menu)
        );

        return $this;
    }

    /**
     * Returns the current navigation menu object.
     *
     * @param  string $key
     * @param  mixed  $default
     * @return mixed
     */
    public function get($key = null, $default = null)
    {
        if (! $this->menu) {
            return $default;
        }

        if (! empty($key)) {
            return $this->menu->{$key} ?? $default;
        }

        return $this->menu;
    }

    /**
     * Determine whether the instance is empty.
     *
     * @return bool
     */
    public function isEmpty()
    {
        return empty($this->items);
    }

    /**
     * Determine whether the instance is not empty.
     *
     * @return bool
     */
    public function isNotEmpty()
    {
        return ! empty($this->items);
    }
}
