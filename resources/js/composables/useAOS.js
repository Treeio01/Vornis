import { onMounted, onUpdated, nextTick } from 'vue';
import { initAOS, useAOS } from '../utils/aos.js';

export function useAOSComposable() {
    const { refreshAOS } = useAOS();
    
    onMounted(() => {
        // Инициализируем AOS при монтировании компонента
        nextTick(() => {
            initAOS();
            refreshAOS();
        });
    });
    
    onUpdated(() => {
        // Обновляем AOS при изменении DOM
        nextTick(() => {
            refreshAOS();
        });
    });
    
    return {
        refreshAOS
    };
}
