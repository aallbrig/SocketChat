<?php
$people = [];

Event::listen('app.personJoin', function($client_data){
  global $people;
  $name = $client_data->data->name;
  // "No server push method", so this event gets sent 2 * n,
  // where n = number of connections.
  $found = false;
  if(sizeof($people) > 0){
    foreach($people as $index=>$person) {
      if($person->name == $name){
        unset($people[$index]);
      }
    }
    if(!$found){
      $people[] = $client_data->data;
    }
  } else {
    $people[] = $client_data->data;
  }
});
Event::listen('app.personLeave', function($client_data){
  global $people;
  $name = $client_data->data->name;
  echo($name . " has left!\n");
  foreach($people as $index=>$person) {
    if($person->name == $name){
      unset($people[$index]);
    }
  }
});
Event::listen('app.getPeople', function($client_data){
  global $people;
  echo("Request for people recieved!\n");
  echo("type of people list is: " . gettype($people));
  return BrainSocket::message('app.sendPeople', (array)$people);
});
Event::listen('app.chatMessage', function($client_data){
  print_r($client_data);
  // Strip dangerous HTML characters from chat.
  $client_data->data->message = trim(preg_replace('/ +/', ' ', preg_replace('/[^A-Za-z0-9 ]/', ' ', urldecode(html_entity_decode(strip_tags($client_data->data->message))))));;
});
// generic events
Event::listen('generic.event',function($client_data){
    return BrainSocket::message('generic.event',array('message'=>'A message from a generic event fired in Laravel!'));
});

Event::listen('app.success',function($client_data){
    return BrainSocket::success(array('There was a Laravel App Success Event!'));
});

Event::listen('app.error',function($client_data){
    return BrainSocket::error(array('There was a Laravel App Error!'));
});