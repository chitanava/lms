import { createRouter, createWebHistory } from 'vue-router';

import GuestLayout from '@/layouts/GuestLayout.vue'
import AuthLayout from '@/layouts/AuthLayout.vue'
import NotFoundLayout from '@/layouts/NotFoundLayout.vue'

import LoginView from '@/views/auth/LoginView.vue'
import RegisterView from '@/views/auth/RegisterView.vue'
import ForgotPasswordView from '@/views/auth/ForgotPasswordView.vue'
import ResetPasswordView from '@/views/auth/ResetPasswordView.vue'
import VerifyEmailView from '@/views/auth/VerifyEmailView.vue'

import HomeView from '@/views/HomeView.vue'

import NotFoundView from '@/views/NotFoundView.vue'

const routes = [
    {
        path: '/login',
        meta: { layout: GuestLayout },
        component: LoginView
    },
    {
        path: '/register',
        meta: { layout: GuestLayout },
        component: RegisterView
    },
    {
        path: '/forgot-password',
        meta: { layout: GuestLayout },
        component: ForgotPasswordView
    },
    {
        path: '/reset-password',
        meta: { layout: GuestLayout },
        component: ResetPasswordView
    },
    {
        path: '/verify-email',
        meta: { layout: GuestLayout },
        component: VerifyEmailView
    },

    {
        path: '/',
        meta: { layout: AuthLayout },
        component: HomeView
    },

    {
        path: '/:notFound',
        meta: { layout: NotFoundLayout },
        component: NotFoundView
    }
]

const router = createRouter({
    history: createWebHistory(),
    routes
})

export default router
