type Paginate = {
    total: string;
    per_page: string;
    current_page: string;
    last_page: string;
    first_page_url: string;
    last_page_url: string;
    next_page_url: string;
    prev_page_url: string;
    path: string;
    from: string;
    to: string;
    data: [];
    links: LinkType[];
};


type LinkType = {
    url?: string;
    label?: string;
    active?: boolean;
};