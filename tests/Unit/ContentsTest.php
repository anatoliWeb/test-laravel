<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Service\Contents as ServiceContents;
use Illuminate\Http\Request;

/**
 * Class ContentsTest
 * @package Tests\Unit
 */
class ContentsTest extends TestCase
{
    /**
     * create row from local and Zoho
     */
    public function testCreateTest()
    {

        $request = new Request();

        $request->merge([
            'email'=>'test@email.com',
            'first_name'=>'test first name',
            'last_name'=>'test last name',
            'phone' => '1234567890'
        ]);

        $service = new ServiceContents();

        $this->assertTrue($service->Create($request));

    }

    /**
     * update row from local and Zoho
     */
    public function testUpdateTest()
    {
        $request = new Request();

        $request->merge([
            'email'=>'testUpdated@email.com',
            'first_name'=>'updated test first name',
            'last_name'=>'updated test last name',
            'phone' => '0987654321'
        ]);

        $service = new ServiceContents();

        $this->assertTrue($service->Update($request, 1));
    }

    /**
     * delete row from local and Zoho
     */
    public function testDeleteTest()
    {

        $service = new ServiceContents();

        $this->assertTrue($service->Delete(1));
    }
}