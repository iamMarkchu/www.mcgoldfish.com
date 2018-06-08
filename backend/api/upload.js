export const UPLOAD_URL = '/admin/upload'
export const ASSETS_URL = '/storage/'
export const FRONT_FULL_URL = 'https://www.querycoupons.com/'
export const FRONT_FULL_URL_WITHOUT_SLASH = 'https://www.querycoupons.com'


let token = document.head.querySelector('meta[name="csrf-token"]');
export const HEADERS = {
    'X-Requested-With': 'XMLHttpRequest',
    'X-CSRF-TOKEN': token.content
}