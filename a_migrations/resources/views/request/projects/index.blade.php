@extends('layouts.app', ['activePage' => 'request'])

@section('content')
    <style>
        .time-progess {

            position: absolute;

            height: 100%;
            top: 0;

            left: 0;
            border-top-left-radius: 15px;
            border-bottom-left-radius: 15px;
        }

        .time-progess-content {

            background-color: rgb(196, 211, 255);
            border-radius: 15px;
            padding-top: 7px;
            position: relative;
            overflow: hidden;
        }


        .select-status1 {
            background-color: rgba(47, 54, 68, 0.3);

        }

        .select-status2 {
            background-color: rgba(247, 144, 9, .3);

        }

        .select-status3 {
            background-color: rgba(39, 174, 96, .3);

        }

        .select-status4 {
            background-color: rgba(240, 68, 56, .3);

        }

        .select-status5 {
            background-color: rgba(79, 143, 239);

        }

        .select-status1:hover,
        .select-status1.active {
            background-color: rgba(47, 54, 68, .6);

        }

        .select-status2:hover,
        .select-status2.active {
            background-color: rgba(247, 144, 9, .6);

        }

        .select-status3:hover,
        .select-status3.active {
            background-color: rgba(39, 174, 96, .6);

        }

        .select-status4:hover,
        .select-status4.active {
            background-color: rgba(240, 68, 56, .6);

        }

        .select-status5:hover,
        .select-status5.active {
            background-color: rgba(79, 143, 239);

        }

        .bomb-bt {
            cursor: pointer;
        }

        .bomb-bt .h4,
        .bomb-bt .h5 {
            color: black;
        }

        .bomb-bt:hover .h4,
        .bomb-bt:hover .h5 {
            color: white;
        }



        .my-text-in-progress div {
            padding: 0 25px;
        }

        .time-progess-content {
            background-color: rgb(196, 211, 255);
            border-radius: 15px;
            position: relative;
            height: 40px;
            overflow: hidden;
        }


        .my-text-in-hide-on-window {
            display: block;

        }

        .my-text-in-progress {
            position: absolute;
            height: 100%;
            top: 0;
            width: 100%;
            left: 0;
            display: flex;
            align-items: center;
            justify-content: space-around;
        }

        .show-on-window {
            display: none;
        }

        @media (min-width: 1000px) {
            .show-on-window {
                display: block;
            }

            .my-text-in-hide-on-window {
                display: none;
            }

            .my-text-in-progress {
                position: absolute;
                height: 100%;
                top: 0;
                width: 100%;
                left: 0;
                display: flex;
                align-items: center;
                justify-content: space-between;
            }

        }
    </style>
    <div class="page">
        @livewire('request.projects.index-component', ['columns' => $columns, 'api' => $api, 'show_status' => $show_status, 'template' => $template])
    </div>
@endsection
