import { createRouter, createWebHistory } from 'vue-router';

import GuestLayout from '@/layouts/GuestLayout.vue'
import AuthLayout from '@/layouts/AuthLayout.vue'
import NotFoundLayout from '@/layouts/NotFoundLayout.vue'

import LoginView from '@/views/auth/LoginView.vue'
import RegisterView from '@/views/auth/RegisterView.vue'
import VerifyEmailView from "@/views/auth/VerifyEmailView.vue"
import ForgotPasswordView from '@/views/auth/ForgotPasswordView.vue'
import ResetPasswordView from '@/views/auth/ResetPasswordView.vue'

import HomeView from '@/views/HomeView.vue'

import NotFoundView from '@/views/NotFoundView.vue'

const routes = [
    {
        path: '/login',
        name: 'login',
        meta: { layout: GuestLayout },
        component: LoginView
    },
    {
        path: '/register',
        name: 'register',
        meta: { layout: GuestLayout },
        component: RegisterView
    },
    {
        path: '/verify-email',
        name: 'verify-email',
        meta: { layout: GuestLayout },
        component: VerifyEmailView
    },
    {
        path: '/forgot-password',
        name: 'forgot-password',
        meta: { layout: GuestLayout },
        component: ForgotPasswordView
    },
    {
        path: '/reset-password',
        name: 'reset-password',
        meta: { layout: GuestLayout },
        component: ResetPasswordView
    },

    {
        path: '/',
        name: 'home',
        meta: { layout: AuthLayout },
        component: HomeView
    },

    {
        path: '/:notFound',
        name: 'not-found',
        meta: { layout: NotFoundLayout },
        component: NotFoundView
    }
]

const router = createRouter({
    history: createWebHistory(),
    routes
})

export default router
