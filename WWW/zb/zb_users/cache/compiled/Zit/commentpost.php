<form id="postcmt" class="pane cmt clear" target="_self" method="post" action="<?php  echo $article->CommentPostUrl;  ?>" >
  <input type="hidden" name="postid" id="inpId" value="<?php  echo $article->ID;  ?>">
  <input type="hidden" name="replyid" id="inpRevID" value="0">
  <img src="<?php  echo $user->Avatar;  ?>" alt="<?php  echo $user->Name;  ?>" class="avatar">
  <cite>
    <b><label><input type="text" name="name" id="inpName" placeholder="<?php  echo $msg->name;  ?>" title="<?php  echo $msg->username;  ?>" value="<?php  echo $user->Name;  ?>"></label></b>
    <small><label><input type="text" name="email" id="inpEmail" placeholder="your@email.addr" title="<?php  echo $msg->email;  ?>" value="<?php  echo $user->Email;  ?>"></label>
    <label><input type="text" name="homepage" id="inpHomePage" placeholder="https://your.home.page" title="<?php  echo $msg->url;  ?>" value="<?php  echo $user->HomePage;  ?>"></label></small>
  </cite>
  <textarea name="content" id="txaArticle" cols="50" rows="2"></textarea>
  <?php if ($option['ZC_COMMENT_VERIFY_ENABLE']&&!$zbp->CheckRights('NoValidCode')) { ?>
  <span class="captcha"><label><input type="text" name="verify" id="inpVerify" placeholder="<?php  echo $msg->captcha;  ?>"></label><img style="width:<?php  echo $option['ZC_VERIFYCODE_WIDTH'];  ?>px;height:<?php  echo $option['ZC_VERIFYCODE_HEIGHT'];  ?>px;cursor:pointer;" src="<?php  echo $article->ValidCodeUrl;  ?>" title="<?php  echo $msg->refresh;  ?>" onclick="javascript:this.src='<?php  echo $article->ValidCodeUrl;  ?>&amp;tm='+Math.random();"></span>
  <?php } ?>
  <button type="submit"><?php  echo $msg->submit;  ?></button>
</form>