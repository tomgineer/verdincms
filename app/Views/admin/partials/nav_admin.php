 <?php if (tier() >= 9): ?>
     <li class="hidden lg:flex">
         <a href="<?= site_url('admin/edit/post/new') ?>" class="gap-1">
             <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5 text-info">
                 <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
             </svg>
             <span>New Post</span>
         </a>
     </li>

     <li class="hidden lg:flex">
         <details>
             <summary>Administration</summary>
             <ul class="bg-base-200 rounded-t-none p-2 min-w-52 shadow-xl">
                 <li>
                     <a href="<?= site_url('admin/edit/page/new') ?>" class="gap-2">
                         <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5 text-info">
                             <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                         </svg>
                         <span>New Page</span>
                     </a>
                 </li>

                 <li class="my-1 border-t border-base-content"></li>

                 <li>
                     <a href="<?= site_url('admin/moderate/drafts/posts') ?>">
                         Drafts <span class="text-info">Posts</span>
                     </a>
                 </li>
                 <li>
                     <a href="<?= site_url('admin/moderate/drafts/pages') ?>">
                         Drafts <span class="text-info">Pages</span>
                     </a>
                 </li>

                 <li class="my-1 border-t border-base-content"></li>

                 <?php if (tier() >= 10): ?>
                     <li>
                         <a href="<?= site_url('admin/moderate/review/posts') ?>">
                             Review <span class="text-info">Posts</span>
                         </a>
                     </li>
                     <li>
                         <a href="<?= site_url('admin/moderate/review/pages') ?>">
                             Review <span class="text-info">Pages</span>
                         </a>
                     </li>

                     <li class="my-1 border-t border-base-content"></li>

                     <li>
                         <a href="<?= site_url('admin/dashboard') ?>" class="gap-2">
                             <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5 text-info">
                                 <path stroke-linecap="round" stroke-linejoin="round" d="M9 17.25v1.007a3 3 0 0 1-.879 2.122L7.5 21h9l-.621-.621A3 3 0 0 1 15 18.257V17.25m6-12V15a2.25 2.25 0 0 1-2.25 2.25H5.25A2.25 2.25 0 0 1 3 15V5.25m18 0A2.25 2.25 0 0 0 18.75 3H5.25A2.25 2.25 0 0 0 3 5.25m18 0V12a2.25 2.25 0 0 1-2.25 2.25H5.25A2.25 2.25 0 0 1 3 12V5.25" />
                             </svg>
                             <span>Dashboard</span>
                         </a>
                     </li>

                     <li>
                         <a href="<?= site_url('admin/analytics') ?>" class="gap-2">
                             <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5 text-info">
                                 <path stroke-linecap="round" stroke-linejoin="round" d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 0 1 3 19.875v-6.75ZM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 0 1-1.125-1.125V8.625ZM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 0 1-1.125-1.125V4.125Z" />
                             </svg>
                             <span>Analytics</span>
                         </a>
                     </li>
                 <?php endif; ?>
             </ul>
         </details>
     </li>
 <?php endif; ?>