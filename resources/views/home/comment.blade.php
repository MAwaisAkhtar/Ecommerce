<div style="text-align: center; padding-bottom:30px">

    <h1 style="font-size: 30px; text-align:center; padding-top: 20px; padding-bottom: 20px;">Comments</h1>
    <form action="{{ route('add_comment') }}" method="POST">
       @csrf
       <textarea name="comment" style="height:150px; width:600px" placeholder="Comment Something Here"></textarea><br>
       <input type="submit" class="btn btn-primary" value="Comment">
    </form>
    </div>

    <div style="padding-left: 20%">
       <h1 style="font-size: 20px; padding-bottom: 20px"><b>All Comments</b></h1>
    </div>

    <div style="padding-left: 20%">
       @foreach ($comment as $comment)
       <div>
          <b>{{ $comment->name }}</b>
          <p>{{ $comment->comment }}</p>
          <a href="javascript::void(0);" onclick="reply(this)" data-Commentid="{{ $comment->id }}" style="color: blue">Reply</a>
          @foreach ($reply as $rep)
          @if ($rep->comment_id == $comment->id)
          <div style="padding-left:3%; padding-bottom:10px;">
             <b>{{ $rep->name }}</b>
             <p>{{ $rep->reply }}</p>
          <a href="javascript::void(0);" onclick="reply(this)" data-Commentid="{{ $comment->id }}" style="color: blue">Reply</a>
          </div>
          @endif
          @endforeach
       </div><br>
       @endforeach
       {{-- reply-box --}}
       <div style="display: none; padding-bottom:20px" class="replydiv">
          <form action="{{ route('add_reply') }}" method="post">
             @csrf
          <input type="text" id="commentId" name="commentId" hidden>
          <textarea style="height: 100; width:500px;" name="reply" placeholder="Write a Reply here"></textarea><br>
          
          <button type="submit" class="btn btn-warning">Reply</button>
          <a href="javascript::void(0);" class="btn" onclick="reply_close(this)">Close</a>
       </form>
       </div>
    </div>