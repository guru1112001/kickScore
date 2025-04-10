<?php

// namespace App\Policies;

// use App\Models\QuestionBank;
// use App\Models\User;
// use Illuminate\Auth\Access\Response;

// class QuestionBankPolicy
// {
//     /**
//      * Determine whether the user can view any models.
//      */
//     public function viewAny(User $user): bool
//     {
//         return $user->can('view_any_question_bank');
//     }

//     /**
//      * Determine whether the user can view the model.
//      */
//     public function view(User $user): bool
//     {
//         return $user->can('view_question_bank');
//     }

//     /**
//      * Determine whether the user can create models.
//      */
//     public function create(User $user): bool
//     {
//         return $user->is_admin || $user->is_tutor;
//     }

//     /**
//      * Determine whether the user can update the model.
//      */
//     public function update(User $user, QuestionBank $question_bank): bool
//     {
//         return $user->is_admin;
//     }

//     /**
//      * Determine whether the user can delete the model.
//      */
//     public function delete(User $user, QuestionBank $question_bank): bool
//     {
//         return $user->is_admin;
//     }

//     /**
//      * Determine whether the user can restore the model.
//      */
//     public function restore(User $user, QuestionBank $question_bank): bool
//     {
//         return $user->is_admin;
//     }

//     /**
//      * Determine whether the user can permanently delete the model.
//      */
//     public function forceDelete(User $user, QuestionBank $question_bank): bool
//     {
//         return $user->is_admin;
//     }
// }
