interface ProductImage {
  id: number
  image_path: string
  alt_text?: string
  is_primary: boolean
  sort_order: number
  url: string
}

interface ProductCategory {
  id: number
  name: string
  slug: string
}

export interface Product {
  id: number
  name: string
  slug: string
  description?: string
  short_description?: string
  sku: string
  price: string
  sale_price?: string
  stock_quantity: number
  brand?: string
  model?: string
  frame_material?: string
  lens_type?: string
  frame_color?: string
  frame_size?: string
  gender: 'male' | 'female' | 'unisex' | 'kids'
  age_group: 'adult' | 'child' | 'senior'
  is_prescription: boolean
  is_sunglasses: boolean
  is_active: boolean
  featured: boolean
  primary_image_url?: string
  images: ProductImage[]
  categories: ProductCategory[]
}

export interface ProductFilters {
  search?: string
  gender?: string
  type?: string
  category?: string
  min_price?: number | string
  max_price?: number | string
  sort?: string
  page?: number
}

export const useProducts = () => {
  const { api } = useApi()
  const config = useRuntimeConfig()

  const storageBase = computed(() =>
    (config.public.apiUrl as string).replace('/api', '') + '/storage/'
  )

  const fetchProducts = async (filters: ProductFilters = {}) => {
    const query: Record<string, string | number> = {}
    Object.entries(filters).forEach(([key, val]) => {
      if (val !== undefined && val !== '' && val !== null) {
        query[key] = val as string | number
      }
    })
    return await api('/products', { query })
  }

  const fetchFeatured = async () => {
    return await api('/products/featured')
  }

  const fetchProduct = async (slug: string) => {
    return await api(`/products/${slug}`)
  }

  const fetchCategories = async () => {
    return await api('/categories')
  }

  const formatPrice = (price: string | number) =>
    `${Number(price).toFixed(2)} RON`

  const genderLabel = (g: string) =>
    ({ male: 'Férfi', female: 'Női', unisex: 'Uniszex', kids: 'Gyerek' }[g] ?? g)

  const ageGroupLabel = (a: string) =>
    ({ adult: 'Felnőtt', child: 'Gyerek', senior: 'Idős' }[a] ?? a)

  return {
    fetchProducts,
    fetchFeatured,
    fetchProduct,
    fetchCategories,
    formatPrice,
    genderLabel,
    ageGroupLabel,
    storageBase,
  }
}
