@extends('layouts.app')

@section('content')
<div class="container">
    <table class="table table-striped">
        <thead>
        <tr>
            <th>Rank</th>
            <th>Name</th>
            <th>Score</th>
        </tr>
        </thead>
        <tbody>
            @foreach($users as $key=>$val)
                <tr class="">
                    <td>{{ $val->id }}</td>
                    <td>{{ $val->name }}</td>
                    <td class="user_score_{{$val->id}}">{{ $val->score }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

<script>
    // if we used npm========================================

    // Echo.channel('leaderboard').listen('ScoreUpdated', (e) => {
    //     console.log('y')
    //     var user = this.users.find((user) => user.id === e.id);
    //     // check if user exists on leaderboard
    //     if(user){
    //         var index = this.users.indexOf(user);
    //         this.users[index].score = e.score;
    //     }
    //     // if not, add 'em
    //     else {
    //         this.users.push(e)
    //     }
    // })
</script>

<script src="https://js.pusher.com/7.1/pusher.min.js"></script>
<script>
    // Enable pusher logging - don't include this in production
    Pusher.logToConsole = true;

    var pusher = new Pusher('a6533a75a7e8815265f6', {
        cluster: 'ap2'
    });

    var channel = pusher.subscribe('leaderboard');
    // console.log(channel);
    
    channel.bind('Score-Updated', function(data) {
        // alert(JSON.stringify(data));
        $(".user_score_"+data.id).html(data.score);
    });

</script>

@endsection
