<?php

namespace Tests\Feature;

use App\Models\Product;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Session;
use Tests\TestCase;
use App\Models\User;

class ProductControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void {
        parent::setUp();

        $user = User::factory()->create();
        $this->actingAs($user);
    }

    /** @test */
    // public function it_displays_all_products_on_index()
    // {
    //     // Create some products
    //     $product1 = Product::create([
    //         'nama' => 'Product 1',
    //         'kategori' => 'Category 1',
    //         'harga' => 1000,
    //     ]);
    //     $product2 = Product::create([
    //         'nama' => 'Product 2',
    //         'kategori' => 'Category 2',
    //         'harga' => 2000,
    //     ]);

    //     // Visit the index page
    //     $response = $this->get(route('admin/products'));

    //     // Assert the products are displayed
    //     $response->assertStatus(200);
    //     $response->assertSee($product1->nama);
    //     $response->assertSee($product2->nama);
    // }

    // /** @test */
    // public function it_displays_create_product_form()
    // {
    //     // Visit the create page
    //     $response = $this->get(route('admin/products/create'));

    //     // Assert that the create page loads successfully
    //     $response->assertStatus(200);
    //     $response->assertSee('Create Product');  // Make sure the view contains "Create Product" text
    // }

    /** @test */
    public function it_can_save_a_new_product()
    {
        // Data for creating a new product
        $productData = Product::factory()->create([
            'nama'=> "5",
            'harga'=> 12712712,
            'kategori' => "aowkaokwa",
        ]);

        if (empty($productData->nama)) {
            $this ->fail("Nama harus di isi kocak");
            return;
        }else if (empty($productData->harga)) {
            $this ->fail("Harga harus di isi kocak");
            return;
        }else if (empty($productData->kategori)) {
            $this ->fail("kategori harus di isi kocak");
            return;
        }

        // Assert the product is saved in the database
        $this->assertDatabaseHas('products', [
            'nama' => $productData->nama,
            'harga' => $productData->harga,
            'kategori' => $productData->kategori,
        ]);


    }

    /** @test */
public function it_can_update_a_product()
{
    // Create a product to be updated
    $product = Product::factory()->create([
        'id' => 5,
        'nama' => 'Old Product Name',
        'harga' => 100000,
        'kategori' => 'Old Category',
    ]);

    // Data to update the product
    $updatedData = [
        'id' => 5,
        'nama' => 'pppp',
        'harga' => 200000,
        'kategori' => 'Updated Category',
    ];

    $productToUpdate = Product::find($updatedData['id']);

    // If the product does not exist, fail the test
    if (!$productToUpdate) {
        $this->fail("ID {$updatedData['id']} gx ada kocak");
    }else  if (empty($updatedData['nama'])) {
        $this ->fail("Nama harus di isi kocak");
        return;
    }else if (empty($updatedData['harga'])) {
        $this ->fail("Harga harus di isi kocak");
        return;
    }else if (empty($updatedData['kategori'])) {
        $this ->fail("kategori harus di isi kocak");
        return;
    }

    // Update the product
    $product->update($updatedData);

    // Assert the product is updated in the database
    $this->assertDatabaseHas('products', $updatedData);

    // Ensure the old data does not exist in the database
    $this->assertDatabaseMissing('products', [
        'nama' => 'Old Product Name',
        'harga' => 100000,
        'kategori' => 'Old Category',
    ]);
}

/** @test */
public function it_can_delete_a_product()
{
    // Create a product to be deleted
    $product = Product::factory()->create([
        'nama' => 'Product to be deleted',
        'harga' => 50000,
        'kategori' => 'Category to delete',
    ]);

    // Delete the product
    $product->delete();

    // Assert the product is deleted from the database
    $this->assertDatabaseMissing('products', [
        'nama' => 'Product to be deleted',
        'harga' => 50000,
        'kategori' => 'Category to delete',
    ]);
}

/** @test */
public function it_can_view_a_product()
{
    // Create a product to view
    $product = Product::factory()->create([
        'nama' => 'Product to view',
        'harga' => 30000,
        'kategori' => 'View Category',
    ]);

    // Retrieve the product from the database
    $viewedProduct = Product::find($product->id);

    // Assert the product data is correct
    $this->assertEquals($product->nama, $viewedProduct->nama);
    $this->assertEquals($product->harga, $viewedProduct->harga);
    $this->assertEquals($product->kategori, $viewedProduct->kategori);
}

}