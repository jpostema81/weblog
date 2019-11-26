<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Category;

class CategoriesServiceProvider extends ServiceProvider {

    public function register()
    {
        $this->app->bind('myCategories', function()
        {
            $categories = Category::all()->toArray();
            return $categories;
        });
    }

}