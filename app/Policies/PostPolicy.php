<?php

    namespace App\Policies;

    use App\models\Post;
    use App\User;
    use Illuminate\Auth\Access\HandlesAuthorization;

    class PostPolicy
    {
        use HandlesAuthorization;

        public function index(User $user , Post $post)
        {
            return true;

            return false;
        }

        /**
         * Determine whether the user can view the post.
         *
         * @param  \App\User $user
         * @param  \App\Post $post
         *
         * @return mixed
         */
        public function view(User $user , Post $post)
        {
            return true;
        }

        /**
         * Determine whether the user can create posts.
         *
         * @param  \App\User $user
         *
         * @return mixed
         */
        public function create(User $user)
        {
            return true;
        }

        /**
         * Determine whether the user can update the post.
         *
         * @param  \App\User $user
         * @param  \App\Post $post
         *
         * @return mixed
         */
        public function update(User $user , Post $post)
        {
            return true;
        }

        /**
         * Determine whether the user can delete the post.
         *
         * @param  \App\User $user
         * @param  \App\Post $post
         *
         * @return mixed
         */
        public function delete(User $user , Post $post)
        {
            return true;
            return false;

        }

        /**
         * Determine whether the user can restore the post.
         *
         * @param  \App\User $user
         * @param  \App\Post $post
         *
         * @return mixed
         */
        public function restore(User $user , Post $post)
        {
            return true;
        }

        /**
         * Determine whether the user can permanently delete the post.
         *
         * @param  \App\User $user
         * @param  \App\Post $post
         *
         * @return mixed
         */
        public function forceDelete(User $user , Post $post)
        {
            return true;
        }
    }
