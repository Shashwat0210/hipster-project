<?php 

namespace Tests\Feature;

use App\Models\Admin;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminProductTest extends TestCase {

  use RefreshDatabase;

  public function test_admin_can_create_product()
  {
    $admin = Admin::factory()->create();

   $response = $this->actingAs($admin, 'admin')
      ->post(route('admin.products.store'), [
          'name' => 'Test Product',
          'description' => 'Test description',
          'price' => 1000,
          'category' => 'Test',
          'stock' => 5,
      ]);

      $response->assertRedirect(route('admin.products.index'));

      $this->assertDatabaseHas('products', [
        'name' => 'Test Product',
        'price' => 1000,
      ]);
  }
}