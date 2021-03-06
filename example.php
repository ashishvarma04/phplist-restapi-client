<?php

/** 
 * 
 * example code for using the phpList API Client
 * 
 * For more information, visit https://github.com/michield/phplist-restapi-client
 * 
 * 
 */

include_once 'phpListRESTApiClient.php';

$apiURL = 'http://website.com/lists/admin/?page=call&pi=restapi';
$login = 'admin';
$password = 'helloworld';

$phpList = new phpListRESTApiClient($apiURL, $login, $password);
$phpList->tmpPath = '/var/tmp';

$subscriberEmail = 'phplistTest@mailinator.com';

if ($phpList->login()) {
    $newListID = $phpList->listAdd('list '.rand(0, 100), 'This is a list made with the example code');
    print 'Our new list has ID '.$newListID.PHP_EOL;

    $subscriberID = $phpList->subscriberFindByEmail($subscriberEmail);

    if (!empty($subscriberID)) {
        $phpList->listSubscriberAdd($newListID, $subscriberID);
        print "Subscriber $subscriberID has been added to the list".PHP_EOL;
    } else {
        $subscriberID = $phpList->subscribe($subscriberEmail, $newListID);
        print "Subscriber has been subscribed to the list with ID $subscriberID".PHP_EOL;
    }

    $lists = $phpList->listsSubscriber($subscriberID);
    print 'The subscriber is now member of '.PHP_EOL;
    foreach ($lists as $list) {
        print "\t".$list->id.' '.$list->name.PHP_EOL;
    }

    print 'Removing subscriber from the list'.PHP_EOL;
    $lists = $phpList->listSubscriberDelete($newListID, $subscriberID);
    print 'The subscriber is now member of '.PHP_EOL;
    foreach ($lists as $list) {
        print "\t".$list->id.' '.$list->name.PHP_EOL;
    }

    print 'And adding the subscriber to the list again'.PHP_EOL;
    $lists = $phpList->listSubscriberAdd($newListID, $subscriberID);
    print 'The subscriber is now member of '.PHP_EOL;
    foreach ($lists as $list) {
        print "\t".$list->id.' '.$list->name.PHP_EOL;
    }
}
