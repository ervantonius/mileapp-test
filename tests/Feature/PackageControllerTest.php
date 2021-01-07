<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Tests\BaseTest;

class PackageControllerTest extends TestCase
{
    use BaseTest;

    protected $model = '\\App\\Package';

    // @list
    public function test_func_list()
    {
        $response = $this->get($this->route('package.list'));

        $response->assertOk();
    }

    // @detail
    public function test_func_detail()
    {
    	$data_package = $this->selfCreate($this->model);

    	$response = $this->get($this->route('package.detail', ['id' => $data_package->id]));

        $response->assertOk();

        // $data_package->forceDelete();
    }

    public function test_func_detail_after_deleted()
    {
    	$data_package = $this->selfCreate($this->model);
    	$data_package->delete();

    	$response = $this->get($this->route('package.detail', ['id' => $data_package->id]));

        $response->assertNotFound();

        // $data_package->forceDelete();
    }

    public function test_func_detail_string()
    {
    	$response = $this->get($this->route('package.detail', ['id' => $this->faker->name]));

        $response->assertNotFound();
    }

    public function test_func_detail_symbols()
    {
    	$response = $this->get($this->route('package.detail', ['id' => '!@#']));

        $response->assertNotFound();
    }

    // @create
    public function test_func_store()
    {
    	$response = $this->post($this->route('package.store'), [
            'customer_name' => $this->faker->name,
            'customer_address' => $this->faker->streetAddress,
            'customer_email' => $this->faker->unique()->safeEmail,
            'customer_phone' => $this->faker->e164PhoneNumber,
            'customer_zip_code' => $this->faker->postcode,
            'customer_zone_code' => $this->faker->state,
            'destination_name' => $this->faker->name,
            'destination_address' => $this->faker->streetAddress,
            'destination_phone' => $this->faker->e164PhoneNumber,
            'destination_address_detail' => $this->faker->address,
            'destination_zip_code' => $this->faker->postcode,
            'destination_zone_code' => $this->faker->state,
            'amount' => $this->faker->randomNumber
    	]);

        $response->assertOk();

        $this->model::latest('id')->first()->forceDelete();
    }

    public function test_func_store_invalid_request()
    {
    	$response = $this->post($this->route('package.store'), [
            'customer_address' => $this->faker->streetAddress,
            'customer_email' => $this->faker->unique()->safeEmail,
            'customer_phone' => $this->faker->e164PhoneNumber,
            'customer_zip_code' => $this->faker->postcode,
            'customer_zone_code' => $this->faker->state,
            'destination_name' => $this->faker->name,
            'destination_address' => $this->faker->streetAddress,
            'destination_phone' => $this->faker->e164PhoneNumber,
            'destination_address_detail' => $this->faker->address,
            'destination_zip_code' => $this->faker->postcode,
            'destination_zone_code' => $this->faker->state,
            'amount' => $this->faker->name,
    	]);

        $response->assertJsonMissingValidationErrors(['customer_name', 'amount']);
        $response->assertStatus(500);
    }

    // @put
    public function test_func_put()
    {
    	$data_package = $this->selfCreate($this->model);

    	$response = $this->put($this->route('package.put', ['id' => $data_package->id]), [
            'customer_name' => $this->faker->name,
    		'customer_address' => $this->faker->streetAddress,
            'customer_email' => $this->faker->unique()->safeEmail,
            'customer_phone' => $this->faker->e164PhoneNumber,
            'customer_zip_code' => $this->faker->postcode,
            'customer_zone_code' => $this->faker->state,
            'destination_name' => $this->faker->name,
            'destination_address' => $this->faker->streetAddress,
            'destination_phone' => $this->faker->e164PhoneNumber,
            'destination_address_detail' => $this->faker->address,
            'destination_zip_code' => $this->faker->postcode,
            'destination_zone_code' => $this->faker->state,
            'amount' => $this->faker->randomNumber,
    	]);

        $response->assertOk();

        // $data_package->forceDelete();
    }

    public function test_func_put_invalid_request()
    {
    	$data_package = $this->selfCreate($this->model);

    	$response = $this->put($this->route('package.put', ['id' => $data_package->id]), [
            'customer_name' => $this->faker->name,
    		'customer_address' => $this->faker->streetAddress,
            'customer_email' => $this->faker->name,
            'customer_phone' => $this->faker->e164PhoneNumber,
            'customer_zip_code' => $this->faker->postcode,
            'customer_zone_code' => $this->faker->state,
            'destination_name' => $this->faker->name,
            'destination_address' => $this->faker->streetAddress,
            'destination_phone' => $this->faker->e164PhoneNumber,
            'destination_address_detail' => $this->faker->address,
            'destination_zip_code' => $this->faker->postcode,
            'destination_zone_code' => $this->faker->state,
            'amount' => $this->faker->name,
    	]);

        $response->assertJsonMissingValidationErrors(['customer_email', 'amount']);
        $response->assertStatus(500);

        // $data_package->forceDelete();
    }

    // @patch
    public function test_func_patch()
    {
        $data_package = $this->selfCreate($this->model);

        $response = $this->patch($this->route('package.patch', ['id' => $data_package->id]), [
            'catatan_tambahan' => $this->faker->sentence,
        ]);

        $response->assertOk();

        // $data_package->forceDelete();
    }

    public function test_func_patch_invalid_request()
    {
        $response = $this->patch($this->route('package.patch', ['id' => $this->faker->name]), [
            'catatan_tambahan' => $this->faker->sentence,
        ]);

        $response->assertStatus(404);
    }

    // @destroy
    public function test_func_destroy()
    {
    	$data_package = $this->selfCreate($this->model);

    	$response = $this->delete($this->route('package.destroy', ['id' => $data_package->id]));

    	$response->assertOk();

    	// $data_package->forceDelete();
    }

    public function test_func_destroy_after_delete()
    {
    	$data_package = $this->selfCreate($this->model);
    	$data_package->forceDelete();

    	$response = $this->delete($this->route('package.destroy', ['id' => $data_package->id]));

    	$response->assertStatus(404);
    }

    public function test_func_destroy_string()
    {
    	$response = $this->delete($this->route('package.destroy', ['id' => $this->faker->name]));

        $response->assertNotFound();
    }

    public function test_func_destroy_symbols()
    {
    	$response = $this->delete($this->route('package.detail', ['id' => '!@#']));

        $response->assertNotFound();
    }
}
