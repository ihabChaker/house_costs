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
     * @requires PHP <= 5.3
     */
    public function test_store(): void
    {
        $house_expense = HouseExpense::factory()->make();
        $response = $this->withoutMiddleware(VerifyCsrfToken::class)
            ->postJson(route('house-expenses.store'), $house_expense->toArray());

        $response->assertStatus(200);
        $house_expense = HouseExpense::latest()->first();
        $this->assertDatabaseHas($house_expense->getTable(), $house_expense->toArray());
        $this->assertNotNull($house_expense->dashboardExpense);
    }

    /**
     * @re/quires PHP <= 5.3
     */
    public function test_update(): void
    {
        $house_expense = HouseExpense::factory()->create();
        $old_amount = $house_expense->amount;
        $new_data = HouseExpense::factory()->make()->toArray();
        $response = $this->withoutMiddleware(VerifyCsrfToken::class)
            ->patchJson(route('house-expenses.update', ['house_expense' => $house_expense]), $new_data);
        $response->assertStatus(200);
        $this->assertDatabaseHas($house_expense->getTable(), [
            'id' => $house_expense->id,
            'amount' => $new_data['amount'],
            'spender_id' => $new_data['spender_id']
        ]);
        $house_expense->setConnection('mysql')->refresh();
        $this->assertNotEquals($old_amount, $house_expense->amount);
        $this->assertEquals($new_data['amount'], $house_expense->dashboardExpense->amount);
        $this->assertEquals($house_expense->amount, $house_expense->dashboardExpense->amount);
    }

    /**
     * @requires PHP <= 5.3
     *
     */
    public function test_delete(): void
    {
        $house_expense = HouseExpense::factory()->create();
        $dashboard_expense_id = $house_expense->dashboardExpense->id;
        $this->assertDatabaseHas('expenses', ['id' => $dashboard_expense_id], 'mysql1');

        $response = $this->withoutMiddleware(VerifyCsrfToken::class)
            ->delete(route('house-expenses.destroy', ['house_expense' => $house_expense]));

        $response->assertStatus(200);
        $this->assertDatabaseMissing($house_expense->getTable(), $house_expense->getAttributes());
        $this->assertDatabaseMissing('expenses', ['id' => $dashboard_expense_id], 'mysql1');
    }
}