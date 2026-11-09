import { Category } from '@/types/category';
import { ProductGroup } from '@/types/product-group';
import { ParamWithPivotValue } from '@/types/param';

export interface Product {
    id: number;
    title: string;
    description: string;
    content: string;
    sku: string;
    price: number;
    old_price: number;
    qty: number;
    category: Category;
    productGroup: ProductGroup;
    images: Image[];
    params: ParamWithPivotValue[];
}

export interface Image {
    url: string;
    id: number;
}
