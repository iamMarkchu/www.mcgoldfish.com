import request from '../utils/request'

const URL = '/categories'

export function add(data) {
    return request({
        url: URL,
        method: 'POST',
        data
    })
}

export function update(data, id) {
    return request({
        url: URL + '/'+ id,
        method: 'PUT',
        data
    })
}

export function fetchList(query) {
    return request({
        url: URL,
        method: 'GET',
        params: query
    })
}

export function fetch(id) {
    return request({
        url: URL + '/'+ id,
        method: 'get'
    })
}

export function tree() {
    return request({
        url: '/categories-tree',
        method: 'get'
    })
}