<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $repositories = [
            \App\Interfaces\AuthenticationRepository::class => \App\Repositories\AuthenticationRepositoryImpl::class,
            \App\Interfaces\CategoryRepository::class => \App\Repositories\CategoryRepositoryImpl::class,
            \App\Interfaces\ChoiceRepository::class => \App\Repositories\ChoiceRepositoryImpl::class,

            \App\Interfaces\CourseRepository::class => \App\Repositories\CourseRepositoryImpl::class,
            \App\Interfaces\DiscountRepository::class => \App\Repositories\DiscountRepositoryImpl::class,
            \App\Interfaces\ExpertRepository::class => \App\Repositories\ExpertRepositoryImpl::class,

            \App\Interfaces\QuizItemRepository::class => \App\Repositories\QuizItemRepositoryImpl::class,
            \App\Interfaces\QuizRepository::class => \App\Repositories\QuizRepositoryImpl::class,
            \App\Interfaces\UserRepository::class => \App\Repositories\UserRepositoryImpl::class,

            \App\Interfaces\VideoGroupRepository::class => \App\Repositories\VideoGroupRepositoryImpl::class,
            \App\Interfaces\VideoRepository::class => \App\Repositories\VideoRepositoryImpl::class,
            \App\Interfaces\WalletRepository::class => \App\Repositories\WalletRepositoryImpl::class,

            \App\Interfaces\StudentRepository::class => \App\Repositories\StudentRepositoryImpl::class,
            \App\Interfaces\FrequentlyQuestionRepository::class => \App\Repositories\FrequentlyQuestionRepositoryImpl::class,
            \App\Interfaces\EnrolmentRepository::class => \App\Repositories\EnrolmentRepositoryImpl::class,
        ];

        foreach ($repositories as $interface => $implementation) {
            $this->app->bind($interface, $implementation);
        }
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
