<section>
    <a href="<?php echo $this->createUrl('/activate/frontend/challenge/' . $challenge->id); ?>" class="text-gray-700 hover:text-gray-600" style="text-decoration: none;">
        <div class="lock-ratio">
            <img src="<?php echo StorageHelper::getUrl($challenge['image_cover']) ?>" alt="" style="object-fit: cover;height: 100%; width: 100%;">
        </div>
        <div>
            <div style="font-size: 18px; font-weight: 800"><?php echo $challenge->title; ?></div>
            <small><?php echo strtoupper(date('d F Y', $challenge['date_close'])); ?></small>
        </div>
    </a>
</section>