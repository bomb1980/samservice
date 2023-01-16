var config = {
        container: "#basic-example",
        
        connectors: {
            type: 'step'
        },
        node: {
            HTMLclass: 'nodeExample1'
        }
    },
    ceo = {
        text: {
            name: "กองบัญชาการกองทัพไทย",
            title: "Chief executive officer",
            contact: "Tel: 01 213 123 134",
        },
        image: "../headshots/2.jpg"
    },

    cto = {
        parent: ceo,
        text:{
            name: "ส่วนบังคับบัญชา",
            title: "Chief Technology Officer",
        },
        stackChildren: true,
        image: "../headshots/1.jpg",
        HTMLclass: 'light-gray',
    },
	cto1 = {
        parent: cto,
        text:{
            name: "สน.ผบ.ทสส.",
            title: "Chief Technology Officer",
        },
        stackChildren: true,
        image: "../headshots/1.jpg",
        HTMLclass: 'light-gray',
    },
    cbo = {
        parent: ceo,
        stackChildren: true,
        text:{
            name: "ส่วนเสนาธิการร่วม",
            title: "Chief Business Officer",
        },
        image: "../headshots/5.jpg"
    },
    cdo = {
        parent: ceo,
        text:{
            name: "ส่วนปฏิบัติการ",
            title: "Chief accounting officer",
            contact: "Tel: 01 213 123 134",
        },
        stackChildren: true,
        image: "../headshots/6.jpg"
    },
	cso = {
        parent: ceo,
        text:{
            name: "ส่วนกิจการพิเศษ",
            title: "Chief accounting officer",
            contact: "Tel: 01 213 123 134",
        },
        stackChildren: true,
        image: "../headshots/6.jpg"
    },
	sbt = {
        parent: cso,
        text:{
            name: "สบ.ทหาร",
            title: "Chief accounting officer",
            contact: "Tel: 01 213 123 134",
        },
        stackChildren: true,
        image: "../headshots/6.jpg"
    },
	gngt = {
        parent: cso,
        text:{
            name: "กง.ทหาร",
            title: "Chief accounting officer",
            contact: "Tel: 01 213 123 134",
        },
        stackChildren: true,
        image: "../headshots/6.jpg"
    },	
	ptt = {
        parent: cso,
        text:{
            name: "ผท.ทหาร",
            title: "Chief accounting officer",
            contact: "Tel: 01 213 123 134",
        },
        stackChildren: true,
        image: "../headshots/6.jpg"
    },
	ybt = {
        parent: cso,
        text:{
            name: "ยบ.ทหาร",
            title: "Chief accounting officer",
            contact: "Tel: 01 213 123 134",
        },
        stackChildren: true,
        image: "../headshots/6.jpg"
    },	
	clo = {
        parent: ceo,
        text:{
            name: "ส่วนการศึกษา",
            title: "Chief accounting officer",
            contact: "Tel: 01 213 123 134",
        },
        image: "../headshots/6.jpg"
    },
	spt = {
        parent: clo,
        text:{
            name: "สปท.",
            title: "Chief accounting officer",
            contact: "Tel: 01 213 123 134",
        },
        image: "../headshots/6.jpg"
    },	
    cio = {
        parent: cto1,
        text:{
            name: "สน.บก.บก.ทท.",
            title: "Chief Information Security Officer"
        },
        image: "../headshots/8.jpg"
    },
    ciso = {
        parent: cto1,
        text:{
            name: "สจร.ทหาร",
            title: "Chief Innovation Officer",
            contact: {val: "we@aregreat.com", href: "mailto:we@aregreat.com"}
        },
        image: "../headshots/9.jpg"
    },
    cio2 = {
        parent: cdo,
        text:{
            name: "นทพ.",
            title: "Chief Customer Officer"
        },
        link: {
            href: "http://www.google.com"
        },
        stackChildren: true,
        image: "../headshots/10.jpg"
    },
    srp = {
        parent: cdo,
        text:{
            name: "ศรภ.",
            title: "Chief Customer Officer"
        },
        link: {
            href: "http://www.google.com"
        },
        stackChildren: true,
        image: "../headshots/10.jpg"
    },
    stg = {
        parent: cdo,
        text:{
            name: "ศตก.",
            title: "Chief Customer Officer"
        },
        link: {
            href: "http://www.google.com"
        },
        stackChildren: true,
        image: "../headshots/10.jpg"
    },    
    ciso2 = {
        parent: cbo,
        text:{
            name: "กพ.ทหาร",
            title: "Chief Communications Officer"
        },
        image: "../headshots/7.jpg"
    },
    ciso3 = {
        parent: cbo,
        text:{
            name: "ขว. ทหาร",
            title: "Chief Brand Officer"
        },
        image: "../headshots/4.jpg"
    },
    ciso4 = {
        parent: cbo,
        text:{
            name: "ยก. ทหาร",
            title: "Chief Business Development Officer"
        },
        image: "../headshots/11.jpg"
    }
    ciso5 = {
        parent: cbo,
        text:{
            name: "กบ. ทหาร",
            title: "Chief Business Development Officer"
        },
        image: "../headshots/11.jpg"
    }
    ciso6 = {
        parent: cbo,
        text:{
            name: "กร. ทหาร",
            title: "Chief Business Development Officer"
        },
        image: "../headshots/11.jpg"
    }

    chart_config = [
        config,
        ceo,
        cto,
		cto1,
        cbo,
        cdo,
		cso,
		sbt,
		gngt,
		ptt,
		ybt,
		clo,
		spt,
        cio,
        ciso,
        cio2,
        srp,
        stg,
        ciso2,
        ciso3,
        ciso4,
        ciso5,
        ciso6
    ];




    // Another approach, same result
    // JSON approach

/*
    var chart_config = {
        chart: {
            container: "#basic-example",
            
            connectors: {
                type: 'step'
            },
            node: {
                HTMLclass: 'nodeExample1'
            }
        },
        nodeStructure: {
            text: {
                name: "Mark Hill",
                title: "Chief executive officer",
                contact: "Tel: 01 213 123 134",
            },
            image: "../headshots/2.jpg",
            children: [
                {
                    text:{
                        name: "Joe Linux",
                        title: "Chief Technology Officer",
                    },
                    stackChildren: true,
                    image: "../headshots/1.jpg",
                    children: [
                        {
                            text:{
                                name: "Ron Blomquist",
                                title: "Chief Information Security Officer"
                            },
                            image: "../headshots/8.jpg"
                        },
                        {
                            text:{
                                name: "Michael Rubin",
                                title: "Chief Innovation Officer",
                                contact: "we@aregreat.com"
                            },
                            image: "../headshots/9.jpg"
                        }
                    ]
                },
                {
                    stackChildren: true,
                    text:{
                        name: "Linda May",
                        title: "Chief Business Officer",
                    },
                    image: "../headshots/5.jpg",
                    children: [
                        {
                            text:{
                                name: "Alice Lopez",
                                title: "Chief Communications Officer"
                            },
                            image: "../headshots/7.jpg"
                        },
                        {
                            text:{
                                name: "Mary Johnson",
                                title: "Chief Brand Officer"
                            },
                            image: "../headshots/4.jpg"
                        },
                        {
                            text:{
                                name: "Kirk Douglas",
                                title: "Chief Business Development Officer"
                            },
                            image: "../headshots/11.jpg"
                        }
                    ]
                },
                {
                    text:{
                        name: "John Green",
                        title: "Chief accounting officer",
                        contact: "Tel: 01 213 123 134",
                    },
                    image: "../headshots/6.jpg",
                    children: [
                        {
                            text:{
                                name: "Erica Reel",
                                title: "Chief Customer Officer"
                            },
                            link: {
                                href: "http://www.google.com"
                            },
                            image: "../headshots/10.jpg"
                        }
                    ]
                }
            ]
        }
    };

*/