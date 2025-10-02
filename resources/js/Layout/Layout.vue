<template>
    <div>
        <transition name="fade" mode="out-in" appear>
            <div> 
            <slot />
            </div>
        </transition>
    </div>
</template>

<style>
.fade-enter-active,
.fade-leave-active {
    transition: opacity 0.3s ease;
}
.fade-enter-from,
.fade-leave-to {
    opacity: 0;
}
</style>
