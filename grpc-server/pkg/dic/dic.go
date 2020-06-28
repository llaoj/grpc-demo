package dic

var JobStatus = map[int]string{
	0: "DRAFT",   // 草稿
	1: "PENDING", //待审核
	2: "OK",      // 正常
	3: "PAUSED",  // 暂停
	4: "BLOCKED", // 禁用
}
