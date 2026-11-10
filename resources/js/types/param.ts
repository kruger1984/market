export interface Param {
    id: number;
    title: string;
    filter_type: number;
    filter_type_label: string;
}

export interface FilterTypeOption {
    value: number;
    label: string;
}

export interface ParamWithPivotValue {
    id: number;
    title: string;
    value: string;
}

export interface ParamFormItem {
    id: number | null;
    value: string;
}
