<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LocalizationTest extends TestCase
{
    use RefreshDatabase;

    public function test_default_locale_is_turkish()
    {
        $this->assertEquals('tr', app()->getLocale());
    }

    public function test_locale_switch_route_changes_session_to_english()
    {
        $response = $this->get(route('locale.switch', 'en'));
        $response->assertSessionHas('locale', 'en');
    }

    public function test_locale_switch_route_changes_session_to_turkish()
    {
        $this->withSession(['locale' => 'en']);
        $response = $this->get(route('locale.switch', 'tr'));
        $response->assertSessionHas('locale', 'tr');
    }

    public function test_middleware_applies_session_locale()
    {
        $response = $this->withSession(['locale' => 'en'])->get(route('home'));
        $response->assertStatus(200);
        $this->assertEquals('en', app()->getLocale());
    }

    public function test_translation_dictionaries_have_matching_keys()
    {
        $tr = json_decode(file_get_contents(base_path('lang/tr.json')), true);
        $en = json_decode(file_get_contents(base_path('lang/en.json')), true);

        $this->assertIsArray($tr);
        $this->assertIsArray($en);

        $trKeys = array_keys($tr);
        $enKeys = array_keys($en);

        $missingInEn = array_diff($trKeys, $enKeys);
        $missingInTr = array_diff($enKeys, $trKeys);

        $this->assertEmpty($missingInEn, 'Missing keys in en.json: ' . implode(', ', $missingInEn));
        $this->assertEmpty($missingInTr, 'Missing keys in tr.json: ' . implode(', ', $missingInTr));
    }
}
