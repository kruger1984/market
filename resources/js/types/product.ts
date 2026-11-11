import { Category } from '@/types/category';
import { ProductGroup } from '@/types/product-group';
import { type ParamFormItem, ParamWithPivotValue } from '@/types/param';

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
    preview_image_url: string;
    has_children: boolean;
    parent_id: number;
}

export interface Image {
    url: string;
    id: number;
}

export interface ProductForm {
    product: {
        title: string;
        sku: string;
        description: string;
        content: string;
        price: number | null;
        old_price: number | null;
        qty: number;
        category_id: number | null;
        product_group_id: number | null;
        parent_id?: number | null;
    };
    images: File[];
    params: ParamFormItem[];
}
