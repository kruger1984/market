export interface ProductParam {
    id: number;
    title?: string;
    label?: string;
}

export interface ParamProductItem {
    id: number;
    param_id: number;
    product_id: number;
    value: string;
    created_at: string | null;
    updated_at: string | null;
    param?: ProductParam;
}

export interface ParamProductGroup {
    title: string | null;
    data: ParamProductItem[];
}
