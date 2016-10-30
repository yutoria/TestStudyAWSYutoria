<?php
require 'vendor/autoload.php';
require '../../aws_config/config.php';
date_default_timezone_set('Asia/Tokyo');

class MyDynamoDB
{
  // データの登録
  public function putItem($table, $data) {
    $sdk = new Aws\Sdk(config::getAws());
    $dynamodb = $sdk->createDynamoDb();

    $response = $dynamodb->putItem([
      'TableName' => $table,
      'Item' => $data,
    ]);

    echo "<pre>";
    print_r($response);
    echo "</pre>";
  }
  
  // データ取得
  public function getItem($table, $key) {
    $sdk = new Aws\Sdk(config::getAws());
    $dynamodb = $sdk->createDynamoDb();

    $response = $dynamodb->getItem([
      'TableName' => $table,
      'Key' => $key,
    ]);

    echo "<pre>";
    print_r($response);
    echo "</pre>";
  }
  
  // データ更新 未完
  public function updateItem($table, $data, $update_data) {
    $sdk = new Aws\Sdk(config::getAws());
    $dynamodb = $sdk->createDynamoDb();

    $response = $dynamodb->updateItem([
      'TableName' => $table,
      'Key' => $data,
      'ExpressionAttributeValues' => $update_data,
      'UpdateExpression' => 'set Authors = :val1, Price = Price - :val2 remove ISBN'
    ]);

    print_r($response);  
  }
  
  // データの削除
  public function deleteItem($table, $data) {
    $sdk = new Aws\Sdk(config::getAws());
    $dynamodb = $sdk->createDynamoDb();
    
    $response = $dynamodb->deleteItem([
      'TableName' => $table,
      'Key' => $data,
    ]);

    echo "<pre>";
    print_r($response);
    echo "</pre>";
  }
  
  // 条件付けでデータの削除
  public function deleteOptionItem($table, $data, $option ) {
    $sdk = new Aws\Sdk(config::getAws());
    $dynamodb = $sdk->createDynamoDb();
    
    $response = $dynamodb->deleteItem([
      'TableName' => $table,
      'Key' =>  [
          $data,
    ],
//    'ExpressionAttributeValues' => [
//      ':val1' => $option,
//    ],
      'ConditionExpression' => $option,
      'ReturnValues' => 'ALL_OLD',
    ]);

    print_r($response);
  }

  // 全件スキャン
  public function scan($table) {
    $sdk = new Aws\Sdk(config::getAws());
    $dynamodb = $sdk->createDynamoDb();

    $response = $dynamodb->scan([
      'TableName' => $table,
    ]);

    echo "<pre>";
    print_r($response);

    foreach ($response['Items'] as $key => $value) {
      echo 'Id: ' . $value['Id']['N'] . "\n";
      echo 'NAME:' . $value['name']['S'] . "\n";
      echo 'HP: ' . $value['HP']['N'] . "\n";
      echo 'MP: ' . $value['MP']['N'] . "\n";
      echo 'STG: ' . $value['stg']['N'] . "\n";
      echo 'MSG:' . $value['msg']['S'] . "\n";
      echo "\n";
    }
    echo "</pre>";
  }

  // 条件を指定してスキャン
  public function searchScan($table, $data) {
    $sdk = new Aws\Sdk(config::getAws());
    $dynamodb = $sdk->createDynamoDb();

    $response = $dynamodb->scan([
      'TableName' => $table,
      'ProjectionExpression' => 'id, HP, MP, stg',
      'ExpressionAttributeValues' => [
        ':val1' => ['N' => '3']] ,
        'FilterExpression' => 'id <= :val1',
    ]);

    echo "<pre>";
    print_r($response);
    echo "</pre>";
  }

  public static function query($table, $type, $fromDate, $toDate)
  {
    $sdk = new Aws\Sdk(config::getAws());
    $dynamodb = $sdk->createDynamoDb();

    $response = $dynamodb->query([
      'TableName' => $table,
      'KeyConditionExpression' => 'id = :v_id',
      'ExpressionAttributeValues' =>  [
        ':v_id' => ['N' => '1']
      ]
    ]);
    echo "<pre>";
    print_r($response);
    echo "</pre>";

  }

 // ２つのテーブルの書き込み 
  public static function setBatchItem($table1, $data1, $table2, $data2) {
    $sdk = new Aws\Sdk(config::getAws());
    $dynamodb = $sdk->createDynamoDb();

    $response = $dynamodb->batchWriteItem([
      'RequestItems' => [
        $table1 => [
          [
            'PutRequest' => [
              'Item' => $data1, 
            ]
          ]
        ],
        $table2 => [
          [
            'PutRequest' => [
              'Item' => $data2,
            ]
          ]
        ]
      ]
    ]);

   echo "<pre>";
   print_r($response);
   echo "</pre>";
  }
  
  // 複数のテーブル取得
  public static function getBatchItem($table1, $data1, $table2, $data2) {
    $sdk = new Aws\Sdk(config::getAws());
    $dynamodb = $sdk->createDynamoDb();

    $response = $dynamodb->batchGetItem([
      'RequestItems' => [
        $table1 => [
          'Keys' => [
            $data1,
          ]
        ],
        $table2 => [
          'Keys' => [
            $data2,
          ]
        ]
      ]
    ]);

    echo "<pre>";
    print_r($response);
    //print_r($response['Responses']);
    echo "</pre>";
  }
  
  // スレッド数取得
  public static function getBatchItemThreads($table1, $data1, $data2) {
    $sdk = new Aws\Sdk(config::getAws());
    $dynamodb = $sdk->createDynamoDb();

    $response = $dynamodb->batchGetItem([
      'RequestItems' => [
        $table1 => [
          'Keys' => [
            $data1,
            $data2,
          ],
          'ProjectionExpression' => 'MP'
        ],
      ]
    ]);

    echo "<pre>";
    //print_r($response);
    print_r($response['Responses']);
    echo "</pre>";
  }
}