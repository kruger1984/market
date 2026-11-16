import { ref } from 'vue';
import type { Product } from '@/types/product';

const filteredProducts = ref<Product[] | null>(null);

export function useFilteredProducts() {
    const setFilteredProducts = (products: Product[]) => {
        filteredProducts.value = products;
    };

    const resetFilteredProducts = () => {
        filteredProducts.value = null;
    };

    return {
        filteredProducts,
        setFilteredProducts,
        resetFilteredProducts,
    };
}
