@extends('layouts.master')

@section('styles')
  @parent
  <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
  <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/bootswatch/3.2.0+2/lumen/bootstrap.min.css">
  <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
  <link rel="stylesheet" href="/css/main.css">
@stop

@section('body')
  @parent
  <div class="container panel panel-default">
    <div class="panel-heading">
      <h1>Websocket Chat Client</h1>
    </div>
    <div class="panel-body row">
      <div class="col-xs-9">
        <div id="chat">
          <!-- Will be full of messages -->
        </div>
        <div id="controls" class="input-group add-on">
          <input id="message" type="text" class="form-control"/>
          <div class="input-group-btn">
            <button id="send" class="btn btn-success" type="submit"><i class="fa fa-fighter-jet"></i></button>
            <button id="clear" class="btn btn-danger" type="submit"><i class="fa fa-remove"></i></button>
          </div>
        </div>
      </div>
      <div class="col-xs-3">
        <ul id="names" class="list-group">
          <!-- <li class="list-group-item">Cras justo odio</li> -->
        </ul>
      </div>
    </div>
  </div>
@stop

@section('scripts')
  @parent
  <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
  <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
  <script src="/vendor/brainsocketjs/brain-socket.min.js"></script>
  <script src="/js/main.js"></script>
@stop