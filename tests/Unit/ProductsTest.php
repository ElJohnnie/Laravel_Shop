<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\Product;

class ProductsTest extends TestCase
{
    /** @test */
    public function check_if_products_model_has_correctly()
    {
        $product = new Product;

        $expect = [
            'name', 'meta_tag_title', 'meta_tag_description', 'description', 'body', 'price', 'slug', 'amount', 'sales'
        ];

        $arrayCompared = array_diff($expect, $product->getFillable());

        $this->assertEquals(0, count($arrayCompared));
    }
}
