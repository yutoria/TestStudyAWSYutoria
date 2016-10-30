<?php
require 'set_dynamodb.php';

//require 'mydynamodb.php';

// 登録
//MyDynamoDB::putItem("test-dynamo", array(
//  'id' => array('N' => '103')
//));

// 登録2
//MyDynamoDB::putItem("test-Character", array(
//  'id' => array('N' => '400'),
//  'name' => array('S' => 'HP'),
//  'stg' => array('N' => '70'),
//));

// 取得
MyDynamoDB::searchScan("test-Character", 'id');

// 取得
//MyDynamoDB::scan("test-Character");

//// 取得
//MyDynamoDB::getItem("test-dynamo", array(
//  'id' => array('N' => '103')
//));

// 削除
//MyDynamoDB::deleteItem("test-dynamo", array(
//  'id' => array('N' => '12')));

// 複数テーブルの書き込み
//MyDynamoDB::setBatchItem('test-dynamo', array(
//  'id' => array('N' => '60')
//), 'test-Character', array( 
//  'id' => array('N' => '60'),
//  'name' => array('S' => 'tiger'),
//  'HP' => array('N' => '800'),
//  'MP' => array('N' => '10'),
//  'stg' => array('N' => '800'),
//  'msg' => array('S' => 'ほげほげほげほげ'),
//));

// 複数テーブルの取得
//MyDynamoDB::getBatchItem('test-dynamo', array(
//  'id' => array('N' => '60')
//), 'test-Character', array(
//  'id' => array('N' => '20') 
//));

// スレッド取得
//MyDynamoDB::getBatchItemThreads('test-Character', array(
//  'id' => array('N' => '5')
//), array(
//  'id' => array('N' => '20')
//));

// クエリで検索
//MyDynamoDB::query("test-dynamo", $type = 1, $fromDate = "2016-01-01 00:00:00", $toDate = "2016-12-31 23:59:59");
