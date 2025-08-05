<script setup lang="ts">
import { Head, Link, useForm, usePage, router } from '@inertiajs/vue3';
import { ref } from 'vue';

import DeleteUser from '@/components/DeleteUser.vue';
import HeadingSmall from '@/components/HeadingSmall.vue';
import InputError from '@/components/InputError.vue';
import Button from '@/components/ui/button/Button.vue';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import AppLayout from '@/layouts/AppLayout.vue';
import SettingsLayout from '@/layouts/settings/Layout.vue';
import { type BreadcrumbItem, type User } from '@/types';
import { useNotifications } from '@/composables/useNotifications';
import { route } from 'ziggy-js';

interface Props {
    mustVerifyEmail: boolean;
    status?: string;
    user: User;
}

const props = defineProps<Props>();
const { success, error } = useNotifications();

const breadcrumbItems: BreadcrumbItem[] = [
    {
        title: 'Profile settings',
        href: '/settings/profile',
    },
];

const avatarInput = ref<HTMLInputElement | null>(null);
const avatarPreview = ref<string | null>(null);

const form = useForm({
    name: props.user.name,
    email: props.user.email,
    phone: props.user.phone || '',
    avatar: null as File | null,
});

// Handle avatar upload
const handleAvatarUpload = (event: Event) => {
    const target = event.target as HTMLInputElement;
    const file = target.files?.[0];
    
    if (file) {
        const reader = new FileReader();
        reader.onload = (e) => {
            avatarPreview.value = e.target?.result as string;
        };
        reader.readAsDataURL(file);
        
        form.avatar = file;
    }
};

// Remove avatar
const removeAvatar = () => {
    if (confirm('Are you sure you want to remove your avatar?')) {
        router.delete(route('profile.remove-avatar'), {
            onSuccess: () => {
                success('Avatar removed successfully!');
                avatarPreview.value = null;
            },
            onError: () => {
                error('Failed to remove avatar.');
            }
        });
    }
};

const submit = () => {
    form.patch(route('profile.update'), {
        preserveScroll: true,
        onSuccess: () => {
            success('Profile updated successfully!');
            avatarPreview.value = null;
        },
        onError: () => {
            error('Failed to update profile. Please check the form.');
        }
    });
};
</script>

<template>
    <AppLayout :breadcrumbs="breadcrumbItems">
        <Head title="Profile settings" />

        <SettingsLayout>
            <div class="flex flex-col space-y-8">
                <!-- Profile Information Section -->
                <div class="space-y-6">
                    <HeadingSmall title="Profile information" description="Update your name, email address and profile picture" />

                    <form @submit.prevent="submit" class="space-y-6">
                        <!-- Avatar Upload Section -->
                        <div class="flex items-center space-x-6">
                            <div class="relative">
                                <div class="w-20 h-20 rounded-full bg-muted border-2 border-border overflow-hidden">
                                    <img
                                        v-if="avatarPreview || user.avatar"
                                        :src="avatarPreview || user.avatar"
                                        :alt="user.name"
                                        class="w-full h-full object-cover"
                                    />
                                    <div v-else class="w-full h-full flex items-center justify-center bg-primary text-primary-foreground text-xl font-semibold">
                                        {{ user.name.charAt(0).toUpperCase() }}
                                    </div>
                                </div>
                                <button
                                    v-if="user.avatar && !avatarPreview"
                                    type="button"
                                    @click="removeAvatar"
                                    class="absolute -top-1 -right-1 w-6 h-6 bg-destructive text-destructive-foreground rounded-full flex items-center justify-center text-xs hover:bg-destructive/90"
                                >
                                    ×
                                </button>
                            </div>
                            
                            <div class="flex-1">
                                <input
                                    ref="avatarInput"
                                    type="file"
                                    accept="image/*"
                                    @change="handleAvatarUpload"
                                    class="hidden"
                                />
                                <Button
                                    type="button"
                                    variant="outline"
                                    @click="avatarInput?.click()"
                                >
                                    Upload Photo
                                </Button>
                                <p class="text-xs text-muted-foreground mt-1">
                                    JPG, PNG or GIF, max 2MB
                                </p>
                                <InputError class="mt-2" :message="form.errors.avatar" />
                            </div>
                        </div>

                        <div class="grid gap-2">
                            <Label for="name">Name</Label>
                            <Input 
                                id="name" 
                                class="mt-1 block w-full" 
                                v-model="form.name" 
                                required 
                                autocomplete="name" 
                                placeholder="Full name" 
                            />
                            <InputError class="mt-2" :message="form.errors.name" />
                        </div>

                        <div class="grid gap-2">
                            <Label for="email">Email address</Label>
                            <Input
                                id="email"
                                type="email"
                                class="mt-1 block w-full"
                                v-model="form.email"
                                required
                                autocomplete="username"
                                placeholder="Email address"
                            />
                            <InputError class="mt-2" :message="form.errors.email" />
                        </div>

                        <div class="grid gap-2">
                            <Label for="phone">Phone Number</Label>
                            <Input
                                id="phone"
                                type="tel"
                                class="mt-1 block w-full"
                                v-model="form.phone"
                                autocomplete="tel"
                                placeholder="+62 812 3456 7890"
                            />
                            <InputError class="mt-2" :message="form.errors.phone" />
                        </div>

                        <div v-if="mustVerifyEmail && !user.email_verified_at">
                            <p class="-mt-4 text-sm text-muted-foreground">
                                Your email address is unverified.
                                <Link
                                    :href="route('verification.send')"
                                    method="post"
                                    as="button"
                                    class="text-foreground underline decoration-neutral-300 underline-offset-4 transition-colors duration-300 ease-out hover:decoration-current! dark:decoration-neutral-500"
                                >
                                    Click here to resend the verification email.
                                </Link>
                            </p>

                            <div v-if="status === 'verification-link-sent'" class="mt-2 text-sm font-medium text-green-600">
                                A new verification link has been sent to your email address.
                            </div>
                        </div>

                        <div class="flex items-center gap-4">
                            <Button :disabled="form.processing">
                                <svg v-if="form.processing" class="animate-spin -ml-1 mr-3 h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                                {{ form.processing ? 'Saving...' : 'Save Changes' }}
                            </Button>

                            <Transition
                                enter-active-class="transition ease-in-out"
                                enter-from-class="opacity-0"
                                leave-active-class="transition ease-in-out"
                                leave-to-class="opacity-0"
                            >
                                <p v-show="form.recentlySuccessful" class="text-sm text-green-600">Saved.</p>
                            </Transition>
                        </div>
                    </form>
                </div>

                <!-- Account Information -->
                <div class="space-y-6">
                    <HeadingSmall title="Account information" description="View your account details" />
                    
                    <div class="bg-card border border-border rounded-lg p-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="flex justify-between items-center">
                                <span class="text-sm text-muted-foreground">User ID</span>
                                <span class="text-sm font-medium">#{{ user.id }}</span>
                            </div>
                            
                            <div class="flex justify-between items-center">
                                <span class="text-sm text-muted-foreground">Account Type</span>
                                <span class="inline-flex items-center px-2 py-1 text-xs font-medium bg-blue-100 text-blue-800 rounded-full">
                                    Customer
                                </span>
                            </div>
                            
                            <div class="flex justify-between items-center">
                                <span class="text-sm text-muted-foreground">Member Since</span>
                                <span class="text-sm font-medium">
                                    {{ new Date(user.created_at).toLocaleDateString() }}
                                </span>
                            </div>
                            
                            <div class="flex justify-between items-center">
                                <span class="text-sm text-muted-foreground">Email Status</span>
                                <span v-if="user.email_verified_at" class="inline-flex items-center px-2 py-1 text-xs font-medium bg-green-100 text-green-800 rounded-full">
                                    Verified
                                </span>
                                <span v-else class="inline-flex items-center px-2 py-1 text-xs font-medium bg-yellow-100 text-yellow-800 rounded-full">
                                    Unverified
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Delete Account Section -->
                <DeleteUser />
            </div>
        </SettingsLayout>
    </AppLayout>
</template>
