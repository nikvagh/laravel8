@extends('layouts.chat')
@section('content')
    @if(request()->has('type'))
        @if(request()->type == 'personal')
            <div class="row chat-row personalChat">
                <div class="chat-content">
                    <ul class="chat-ul"></ul>
                </div>

                <div class="chat-section">
                    <div class="chat-box">
                        <div class="chat-input" id="chatInput" contenteditable="" style="border: 1px dotted gray;">

                        </div>
                    </div>
                </div>
            </div>
        @elseif(request()->type == 'task')
            <div class="row chat-row taskChat">
                <div class="chat-content">
                    <ul class="chat-ul"></ul>
                </div>

                <div class="chat-section">
                    <div class="chat-box">
                        <div class="chat-input" id="chatInput" contenteditable="" style="border: 1px dotted gray;">

                        </div>
                    </div>
                </div>
            </div>
        @endif
    @else
        <div class="row chat-row">
            <div class="chat-content allChat">
                <ul class="chat-ul"></ul>
            </div>

            <div class="chat-section">
                <div class="chat-box">
                    <div class="chat-input" id="chatInput" contenteditable="" style="border: 1px dotted gray;">

                    </div>
                </div>
            </div>
        </div>
    @endif
@endsection