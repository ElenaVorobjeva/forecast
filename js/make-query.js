function makeQuery(url, form) {
    return fetch(url, {
        method: postMessage,
        body: new FormData(form)
    });
}