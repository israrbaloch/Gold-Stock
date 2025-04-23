export interface ProductsPage {
    current_page: number;
    data: Product[];
    first_page_url: string;
    from: number;
    last_page: number;
    last_page_url: string;
    links: Link[];
    next_page_url: string;
    path: string;
    per_page: number;
    prev_page_url: null;
    to: number;
    total: number;
}

export interface Product {
    id: number;
    name: string;
    sku: string;
    type: Type;
    description: null | string;
    metal_id: number;
    price: number;
    physical_price: number;
    images: string;
    backup_images: string;
    tags: null;
    percent_interval_1: number;
    percent_interval_2: number;
    percent_interval_3: number;
    percent_interval_4: number;
    percent_interval_cc_1: number;
    percent_interval_cc_2: number;
    percent_interval_cc_3: number;
    percent_interval_cc_4: number;
    shop_position: number;
    weight: string;
    purity: Purity;
    producer: string;
    in_stock: boolean;
    enabled: boolean;
    status: null;
    created_at: Date;
    updated_at: Date;
    deleted_at: null;
    real_price: number;
    weight_oz: number | string;
    metal_name: MetalName;
    url_name: string;
}

export enum MetalName {
    Gold = "Gold",
    Platinum = "Platinum",
    Silver = "Silver",
}

export enum Purity {
    Empty = "",
    The9999 = "99.99%",
}

export enum Type {
    Bar = "bar",
    Coin = "coin",
}

export interface Link {
    url: null | string;
    label: string;
    active: boolean;
}
