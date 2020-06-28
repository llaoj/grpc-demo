package model

type Company struct {
	Id   int
	Name string
}

func (Company) TableName() string {
	return "company"
}

func (c *Company) GetName(id int) string {
	// db.First(c, id)
	// return c.Name
	return "测试公司名"
}
