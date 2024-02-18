<?php


// use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Illuminate\Support\Facades\DB;


class Test extends TestCase {

    public $view;

    public function setUp(): void
    {
        parent::setUp();
        $insert_test_data = "
            insert into products (name, purchase_price, selling_price, comment)
            values
            ('Продукт 1', 10, 11, 'Продукт Комментарий 1'),
            	('Продукт 2', 20, 21, 'Продукт Комментарий 2'),
            	('Продукт 3', 30, 31, 'Продукт Комментарий 3'),
            	('Продукт 4', 40, 41, 'Продукт Комментарий 4')
            ;

            insert into storages (name, address, comment)
            values
            ('Склад 1', 'Адрес 1', 'Комментарий 1'),
            	('Склад 2', 'Адрес 2', 'Комментарий 2'),
                ('Склад 3', 'Адрес 3', 'Комментарий 3'),
                ('Склад 4', 'Адрес 4', 'Комментарий 4')
            ;

            insert into purchases (date, operation_type, product_id, quantity, price, storage_id, comment)
            values
                ('2001-12-21', 'purchase', (select id from products where name = 'Продукт 1'), 10, 199, (select id from storages where name = 'Склад 1'), 'Комментарий 1'),
            	('2002-12-22', 'purchase', (select id from products where name = 'Продукт 2'), 20, 299, (select id from storages where name = 'Склад 2'), 'Комментарий 2'),
            	('2003-12-23', 'purchase', (select id from products where name = 'Продукт 3'), 30, 399, (select id from storages where name = 'Склад 3'), 'Комментарий 3'),
            	('2004-12-24', 'purchase', (select id from products where name = 'Продукт 4'), 40, 499, (select id from storages where name = 'Склад 4'), 'Комментарий 4')
            ;
        ";
        DB::raw($insert_test_data);

    }


    public function test_rows_showing(): void {

        $view = $this->get('/purchases/show');

        /*
        $cells_values = [
            '21/12/2001', 'Продукт 1', '10', '199', 'Склад 1', 'Комментарий 1',
            '22/12/2002', 'Продукт 2', '20', '299', 'Склад 2', 'Комментарий 2',
            '23/12/2003', 'Продукт 3', '30', '399', 'Склад 3', 'Комментарий 3',
            '24/12/2004', 'Продукт 4', '40', '499', 'Склад 4', 'Комментарий 4'
        ];

        foreach ($cells_values as $cell_value) {
            $view->assertSeeText(e($cell_value), false);
        }
        */

        $view->assertViewHas(e('21/12/2001'), false)
            ->assertViewHas(e('22/12/2002'), false)
            ->assertViewHas(e('23/12/2003'), false)
            ->assertViewHas(e('24/12/2004'), false)

            ->assertViewHas(e('Продукт 1'), false)
            ->assertViewHas(e('Продукт 2'), false)
            ->assertViewHas(e('Продукт 3'), false)
            ->assertViewHas(e('Продукт 4'), false)

            ->assertViewHas(e('10'), false)
            ->assertViewHas(e('20'), false)
            ->assertViewHas(e('30'), false)
            ->assertViewHas(e('40'), false)

            ->assertViewHas(e('199'), false)
            ->assertViewHas(e('299'), false)
            ->assertViewHas(e('399'), false)
            ->assertViewHas(e('499'), false)

            ->assertViewHas(e('Склад 1'), false)
            ->assertViewHas(e('Склад 2'), false)
            ->assertViewHas(e('Склад 3'), false)
            ->assertViewHas(e('Склад 4'), false)

            ->assertViewHas(e('Комментарий 1'), false)
            ->assertViewHas(e('Комментарий 2'), false)
            ->assertViewHas(e('Комментарий 3'), false)
            ->assertViewHas(e('Комментарий 4'), false);

    }
}

