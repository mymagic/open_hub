<?php foreach ($navs as $nav) : ?>
    <?php if ($nav['visible']) : ?>
        <div class="w-full flex <?php echo $nav['active'] ? 'nav-select shadow-panel' : '' ?>">
            <div class="flex-1 list-none">
                <a class="inline-block flex items-center mx-3 py-4 text-gray-900 hover:text-gray-500 focus:text-gray-500 no-underline hover:no-underline focus:no-underline" href="<?php echo $nav['url'] ?>">
                    <div class="ml-2"><i class="fa <?php echo $nav['icon'] ?> text-gray-900 hover:text-gray-500 focus:text-gray-500 no-underline hover:no-underline focus:no-underline" style="font-size: 20px"></i></div>
                    <div class="ml-6 text-lg font-medium break-words text-gray-900 hover:text-gray-500 focus:text-gray-500 no-underline hover:no-underline focus:no-underline"><?php echo $nav['label'] ?></div>
                </a>
            </div>
        </div>
    <?php endif; ?>
<?php endforeach; ?>