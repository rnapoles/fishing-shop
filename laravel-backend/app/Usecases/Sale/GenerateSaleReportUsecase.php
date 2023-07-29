<?php

namespace App\Usecases\Sale;

use App\Exceptions\ValidationException;
use App\Models\Category;
use App\Models\Product;
use App\Models\Sale;
use Illuminate\Support\Facades\DB;
use Throwable;
use Validator;

class GenerateSaleReportUsecase
{

    public function execute(): string
    {
        return $this->generateHTML();
    }
    
    private function generateHTML(): string {
      
      $table = $this->generateTable();
      
      $html = <<<END
        <!DOCTYPE html>
        <html>
          <head>
            <style>

              h2, td {
                text-align: center;
              }
              
              table, th, td {
                border: 1px solid black;
                border-collapse: collapse;
              }
            </style>
          </head>
          <body>

            <h2>Reporte de ventas</h2>
            $table
          </body>
        </html>
      END;
      
      return $html;
    }

    private function generateTable(): string {
      
        $pivot = [];
        $categories = Category::all();
        foreach($categories as $category){
          $key = $category->name;
          $pivot[$key] = [
            'header' => $key,
            'total' => 0,
            'utility' => 0,
          ];
        }

        $pivot['Total'] = [
          'header' => 'Total',
          'total' => 0,
          'utility' => 0,
        ];

        //todo: move to OLAP Cube
        $calcs = DB::table('products')
          ->select(
            DB::raw('categories.name as category'),
            DB::raw('SUM(product_sale.quantity) as total'),
            DB::raw('SUM(((products.sale_price - products.purchase_price) /  products.purchase_price) * 100) AS utility'),
          )
          ->join('categories', 'products.category_id', '=', 'categories.id')
          ->join('product_sale', 'products.id', '=', 'product_sale.product')
          ->groupBy('category')
          ->orderBy('categories.id')
          ->get()
        ;
        
        foreach($calcs as $calc){
          $key = $calc->category;
          $total = $calc->total;
          $utility = round($calc->utility, 2);
          $pivot[$key]['total'] = $total;
          $pivot[$key]['utility'] = $utility;
          $pivot['Total']['total'] += $total;
          $pivot['Total']['utility'] += $utility;
        }

        $table = '';
        $tableHeader = '';
        $tableSubHeader = '';
        $tableData = '';
        foreach($pivot as $column => $row){
          
          $tableHeader .= "     <th colspan='2'>\n";
          $tableHeader .= "       $column\n";
          $tableHeader .= "     </th>\n";

          $tableSubHeader .= "    <th>\n";
          $tableSubHeader .= "      Total Vendido\n";
          $tableSubHeader .= "    </th>\n";
          $tableSubHeader .= "    <th>\n";
          $tableSubHeader .= "      Utilidades\n";
          $tableSubHeader .= "    </th>\n";

          $tableData .= "     <td>\n";
          $tableData .= $row['total'] . "\n";
          $tableData .= "     </td>\n";
          $tableData .= "   <td>\n";
          $tableData .= $row['utility'] . "\n";
          $tableData .= "    </td>\n";

        }

        $table .= "<table style='width:100%'>\n";
        $table .= "  <tr>\n";
        $table .= $tableHeader;
        $table .= "  </tr>\n";
        $table .= "  <tr>\n";
        $table .= $tableSubHeader;
        $table .= "  </tr>\n";
        $table .= "  <tr>\n";
        $table .= $tableData;
        $table .= "  </tr>\n";
        $table .= "</table>\n";

        return $table;
      
    }
}
