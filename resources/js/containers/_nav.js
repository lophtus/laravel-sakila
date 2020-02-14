export default [
    {
        _name: 'CSidebarNav',
        _children: [
            {
                _name: 'CSidebarNavItem',
                name: 'Customers',
                to: '/customers',
                fontIcon: 'far fa-user-circle'
            },
            {
                _name: 'CSidebarNavItem',
                name: 'Films',
                to: {name: "film-list"},
                fontIcon: 'far fa-list-alt'
            },
            {
                _name: 'CSidebarNavItem',
                name: 'Stores',
                to: '/stores',
                fontIcon: 'far fa-map'
            }
        ]
    }
]
