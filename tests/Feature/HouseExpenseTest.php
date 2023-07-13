<?php

namespace Tests\Feature;

use App\Models\HouseExpense;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Tests\TestCase;

/**
 * @requ/ires PHP <= 5.3
 */
class HouseExpenseTest extends TestCase
{
    /**
     * @req/uires PHP <= 5.3
     */
    public function test_store(): void
    {
        $house_expense = HouseExpense::factory()->make();
        $response = $this->withoutMiddleware(VerifyCsrfToken::class)
            ->postJson(route('house-expenses.store'), $house_expense->toArray());

        $response->assertStatus(200);
        $this->assertDatabaseHas($house_expense->getTable(), $house_expense->toArray());
    }

    /**
     * @requi/res PHP <= 5.3
     */
    public function test_update(): void
    {
        $house_expense = HouseExpense::factory()->create();
        $new_data = HouseExpense::factory()->make()->toArray();
        $response = $this->withoutMiddleware(VerifyCsrfToken::class)
            ->patchJson(route('house-expenses.update', ['house_expense' => $house_expense]), $new_data);

        $response->assertStatus(200);
        $this->assertDatabaseHas($house_expense->getTable(), $new_data);
    }

    /**
     * @requi/res PHP <= 5.3
     *
     * @return void
     */
    public function test_delete(): void
    {
        $house_expense = HouseExpense::factory()->create();
        $response = $this->withoutMiddleware(VerifyCsrfToken::class)
            ->delete(route('house-expenses.destroy', ['house_expense' => $house_expense]));

        $response->assertStatus(200);
        $this->assertDatabaseMissing($house_expense->getTable(), $house_expense->getAttributes());
    }
}