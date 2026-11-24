export interface Cart {
    id: number;
    product_id: number;
    qty: number;
}

export interface CartWithProductAndTotal {
    id: number;
    product_title: string;
    product_image_url: string;
    total_sum: number;
    qty: number;
    product_id: number;
    carts_total_sum: number;
}

export interface CartWithProduct {
    id: number;
    product_title: string;
    product_image_url: string;
    total_sum: number;
    qty: number;
    product_id: number;
}
