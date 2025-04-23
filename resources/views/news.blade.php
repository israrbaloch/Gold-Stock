@include('header.index')
<link href="{{ URL::to('/') }}/css/style-new.css?ver=1.2.0" rel="stylesheet">
<link href="{{ URL::to('/') }}/css/news.css?ver=1.0.0" rel="stylesheet">
<?php $prev_img=0; ?>
<br><br>
<div class="page-container container ">
<div class="title-page-1 text-center">NEWS</div>
    <div class="row">
        <?php foreach($news as $i => $new) {?>
            <?php if(strlen($new->url)){?>
            <div class="col-12 col-md-6">
                <div id="new-<?= $i ?>" class="row news-row g-0" onclick="window.open('<?=$new->url?>', '_blank');" >
                    <div class="col-12">
                        <div class="img-container">
                        <?php if(strlen($new->image) && (str_ends_with($new->image, ".jpg") || str_ends_with($new->image, ".png" ))){?>
                            <img class="news-img-n" src="<?=$new->image?>" alt="{{ strip_tags($new->title) }}">
                        <?php } else{
                            do {
                            $img_n = rand(1,7);
                            }while($img_n == $prev_img);
                            $srcimage='img/news/news-'.$img_n.".jpg";
                            ?>
                            <img class="news-img-n" src=" {{ asset($srcimage) }} " alt="{{ strip_tags($new->title) }}">
                        <?php $prev_img = $img_n; }?>
                        </div>
                    </div>
                    <div class="col-12 new-title text-bold">
                        <?=strip_tags($new->title)?>
                    </div>
                    <div class="col-12 new-desc">
                        <?php
                            $text = strip_tags($new->description);
                            // we don't want new lines in our preview
                            $text_only_spaces = preg_replace('/\s+/', ' ', $text);

                            // truncates the text
                            $text_truncated = strlen($text) > 500 ? mb_substr($text_only_spaces, 0, mb_strpos($text_only_spaces, " ", 500)) : $text;

                            // prevents last word truncation
                            $desc = strlen($text) > 500 ? trim(mb_substr($text_truncated, 0, mb_strrpos($text_truncated, " "))) . "..." : $text;
                            echo $desc;
                        ?>
                    </div>
                    <div class="col-12 col-md-7 date-info align-middle">
                        <?php
                            $ts = strtotime($new->date);
                            $d = new DateTime("@".$ts); //@ is for UTC
                            $d->setTimezone(new DateTimeZone('America/Toronto'));
                            $date = $d->format('g:i A, Y-m-d');
                        ?>
                        <span class="author-cont"><?=$new->author?></span> - <span class="date-cont"><?= $date ?></span></<span>
                    </div>
                    <div class="col-12 col-md-5 text-right align-middle">
                        <button type="submit" class="button makeup-btn-dark-green" name="register">Read more</button>
                    </div>
                </div>
            </div>
        <?php } } ?>
    </div>

</div>
@include('footer')