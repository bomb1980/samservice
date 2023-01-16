var config = {
        container: "#custom-colored",
        
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
            title: "",
            contact: "",
        },
        image: ""
    },

    cto = {
        parent: ceo,
        text:{
            name: "ส่วนบังคับบัญชา",
            title: "",
        },
        stackChildren: true,
        image: "",
    },
	cto1 = {
        parent: cto,
        text:{
            name: "สน.ผบ.ทสส.",
            title: "",
        },
        stackChildren: true,
        image: "",
    },
    cbo = {
        parent: ceo,
        stackChildren: true,
        text:{
            name: "ส่วนเสนาธิการร่วม",
            title: "",
        },
        image: ""
    },
    cdo = {
        parent: ceo,
        text:{
            name: "ส่วนปฏิบัติการ",
            title: "",
            contact: "",
        },
        stackChildren: true,
        image: ""
    },
	cso = {
        parent: ceo,
        text:{
            name: "ส่วนกิจการพิเศษ",
            title: "",
            contact: "",
        },
        stackChildren: true,
        image: ""
    },
	sbt = {
        parent: cso,
        text:{
            name: "สบ.ทหาร",
            title: "",
            contact: "",
        },
        stackChildren: true,
        image: ""
    },
	gngt = {
        parent: cso,
        text:{
            name: "กง.ทหาร",
            title: "",
            contact: "",
        },
        stackChildren: true,
        image: ""
    },	
	ptt = {
        parent: cso,
        text:{
            name: "ผท.ทหาร",
            title: "",
            contact: "",
        },
        stackChildren: true,
        image: ""
    },
	ybt = {
        parent: cso,
        text:{
            name: "ยบ.ทหาร",
            title: "",
            contact: "",
        },
        stackChildren: true,
        image: ""
    },	
	clo = {
        parent: ceo,
        text:{
            name: "ส่วนการศึกษา",
            title: "",
            contact: "",
        },
        image: ""
    },
	spt = {
        parent: clo,
        text:{
            name: "สปท.",
            title: "",
            contact: "",
        },
        image: ""
    },	
    cio = {
        parent: cto1,
        text:{
            name: "สน.บก.บก.ทท.",
            title: ""
        },
        image: ""
    },
    ciso = {
        parent: cto1,
        text:{
            name: "สจร.ทหาร",
            title: "",
            //contact: {val: "", href: ""}
        },
        link: {
            href: "http://127.0.0.1:92/orgs/orgs/vieworg/5",
            target: "_blank"
        },
        image: "",
    },
    cio2 = {
        parent: cdo,
        text:{
            name: "นทพ.",
            title: ""
        },
        link: {
            href: ""
        },
        stackChildren: true,
        image: ""
    },
    srp = {
        parent: cdo,
        text:{
            name: "ศรภ.",
            title: ""
        },
        link: {
            href: ""
        },
        stackChildren: true,
        image: ""
    },
    stg = {
        parent: cdo,
        text:{
            name: "ศตก.",
            title: ""
        },
        link: {
            href: ""
        },
        stackChildren: true,
        image: ""
    },    
    ciso2 = {
        parent: cbo,
        text:{
            name: "กพ.ทหาร",
            title: ""
        },
        image: ""
    },
    ciso3 = {
        parent: cbo,
        text:{
            name: "ขว. ทหาร",
            title: ""
        },
        image: ""
    },
    ciso4 = {
        parent: cbo,
        text:{
            name: "ยก. ทหาร",
            title: ""
        },
        image: ""
    }
    ciso5 = {
        parent: cbo,
        text:{
            name: "กบ. ทหาร",
            title: ""
        },
        image: ""
    }
    ciso6 = {
        parent: cbo,
        text:{
            name: "กร. ทหาร",
            title: ""
        },
        image: ""
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